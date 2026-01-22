<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificateTemplate;
use Illuminate\Support\Facades\DB;

class CertificateTemplateController extends Controller
{
    // ===============================
    // TAMPILKAN HALAMAN TEMPLATE
    // ===============================
    public function index()
    {
        $templates = CertificateTemplate::orderBy('created_at', 'desc')->get();
        return view('admin.template-sertif', compact('templates'));
    }

    // ===============================
    // SIMPAN TEMPLATE BARU (UPLOAD)
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // simpan ke public/certificates
        $file->move(public_path('certificates'), $fileName);

        CertificateTemplate::create([
            'name'        => $request->name,
            'file_name'  => $fileName,
            'is_active'  => false,

            // default setting nama
            'pos_x'       => 50,
            'pos_y'       => 55,
            'font_family' => 'Arial',
            'font_size'   => 36,
            'font_color'  => '#000000',
            'font_weight' => 700,
            'font_style'  => 'normal',
        ]);

        return redirect()
            ->route('admin.template-sertifikat.index')
            ->with('success', 'Template sertifikat berhasil diupload');
    }

    // ===============================
    // UPDATE SETTING NAMA SERTIFIKAT
    // ===============================
public function updateSetting(Request $request, $id)
{
    $validated = $request->validate([
        // TEXT BOX (INI INTINYA)
        'box_x'       => 'required|numeric|min:0|max:100',
        'box_y'       => 'required|numeric|min:0|max:100',
        'box_width'   => 'required|numeric|min:1|max:100',
        'box_height'  => 'required|numeric|min:1|max:100',

        // FONT
        'font_family'    => 'required|string|max:100',
        'font_size'      => 'required|integer|min:8|max:200',
        'font_color'     => 'required|string|max:20',
        'font_weight'    => 'required|string|max:10',
        'font_style'     => 'required|string|max:10',
        'letter_spacing' => 'nullable|numeric',
        'text_align'     => 'nullable|string|max:10',
    ]);

    $template = CertificateTemplate::findOrFail($id);

    $template->update($validated);

    return response()->json([
        'status'  => 'success',
        'message' => 'Setting template (text box) berhasil disimpan'
    ]);
}

    // ===============================
    // AKTIFKAN TEMPLATE (1 SAJA)
    // ===============================
    public function activate($id)
    {
        DB::transaction(function () use ($id) {
            // nonaktifkan semua
            CertificateTemplate::where('is_active', true)
                ->update(['is_active' => false]);

            // aktifkan yang dipilih
            CertificateTemplate::where('id', $id)
                ->update(['is_active' => true]);
        });

        return redirect()
            ->back()
            ->with('success', 'Template berhasil diaktifkan');
    }

    // ===============================
    // HAPUS TEMPLATE
    // ===============================
    public function destroy($id)
   {
    $template = CertificateTemplate::findOrFail($id);

    // ❌ Cegah hapus template aktif
    if ($template->is_active) {
        return redirect()
            ->back()
            ->with('error', 'Template aktif tidak dapat dihapus. Nonaktifkan terlebih dahulu.');
    }

    // 🗑️ Hapus file fisik
    $filePath = public_path('certificates/' . $template->file_name);
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // 🗑️ Hapus database
    $template->delete();

    return redirect()
        ->back()
        ->with('success', 'Template berhasil dihapus');
    }

}
