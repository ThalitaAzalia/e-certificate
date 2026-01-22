<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvaluasiQuestion;

class EvaluasiQuestionController extends Controller
{
    /**
     * =========================================================
     * INDEX
     * Halaman Admin Form Evaluasi + Filter (Search & Type)
     * =========================================================
     */
    public function index(Request $request)
    {
        $query = EvaluasiQuestion::query();

        // 🔍 Filter: Cari pertanyaan
        if ($request->filled('search')) {
            $query->where('question', 'like', '%' . $request->search . '%');
        }

        // 🔽 Filter: Tipe pertanyaan
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $questions = $query
            ->orderBy('urutan', 'asc')
            ->get();

        return view('admin.form-evaluasi', compact('questions'));
    }

    /**
     * =========================================================
     * STORE
     * Simpan pertanyaan evaluasi baru
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'type'     => 'required|in:rating,text,textarea',
            'urutan'   => 'required|integer|min:1',
        ]);

        EvaluasiQuestion::create([
            'question' => $request->question,
            'type'     => $request->type,
            'urutan'   => $request->urutan,
        ]);

        return redirect()->back()
            ->with('success', 'Pertanyaan evaluasi berhasil ditambahkan');
    }

    /**
     * =========================================================
     * UPDATE
     * Update pertanyaan evaluasi (via modal edit)
     * =========================================================
     */
    public function update(Request $request, EvaluasiQuestion $question)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'type'     => 'required|in:rating,text,textarea',
            'urutan'   => 'required|integer|min:1',
        ]);

        $question->update([
            'question' => $request->question,
            'type'     => $request->type,
            'urutan'   => $request->urutan,
        ]);

        return redirect()->back()
            ->with('success', 'Pertanyaan evaluasi berhasil diperbarui');
    }

    /**
     * =========================================================
     * DESTROY
     * Hapus pertanyaan evaluasi
     * =========================================================
     */
    public function destroy(EvaluasiQuestion $question)
    {
        $question->delete();

        return redirect()->back()
            ->with('success', 'Pertanyaan evaluasi berhasil dihapus');
    }
}
