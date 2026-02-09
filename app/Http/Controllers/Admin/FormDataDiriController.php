<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormField;

class FormDataDiriController extends Controller
{
    public function index(Request $request)
    {
        $query = FormField::query();

        // 🔍 Filter pencarian (label & key)
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('label', 'like', '%' . $request->q . '%')
                ->orWhere('field_key', 'like', '%' . $request->q . '%');
            });
        }

        // ✅ Filter wajib / tidak wajib
        if ($request->filled('required')) {
            $query->where('required', $request->required);
        }

        // 🧩 Filter tipe input
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $fields = $query
            ->orderBy('sort_order')
            ->get();

        return view('admin.form-datadiri', compact('fields'));
    }


    // ======================
    // CREATE
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            'label'      => 'required',
            'field_key'  => 'required|unique:form_fields,field_key',
            'type'       => 'required',
            'required'   => 'required|boolean',
            'sort_order' => 'required|integer',
        ]);

        FormField::create([
            'label'       => $request->label,
            'field_key'   => $request->field_key,
            'type'        => $request->type,
            'required'    => $request->required,
            'active'      => true,
            'sort_order'  => $request->sort_order,
            'placeholder' => $request->placeholder,
            'admin_note'  => $request->admin_note,
        ]);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    // ======================
    // UPDATE
    // ======================
    public function update(Request $request, FormField $field)
    {
        $request->validate([
            'label'      => 'required',
            'type'       => 'required',
            'required'   => 'required|boolean',
            'sort_order' => 'required|integer',
        ]);

        $field->update([
            'label'       => $request->label,
            'type'        => $request->type,
            'required'    => $request->required,
            'sort_order'  => $request->sort_order,
            'placeholder' => $request->placeholder,
            'admin_note'  => $request->admin_note,
        ]);

        return back()->with('success', 'Pertanyaan berhasil diperbarui');
    }

    // ======================
    // DELETE
    // ======================
    public function destroy(FormField $field)
    {
        $field->delete();
      return redirect()
    ->route('admin.form-datadiri')
    ->with('success', 'Pertanyaan berhasil dihapus');
    }
}
