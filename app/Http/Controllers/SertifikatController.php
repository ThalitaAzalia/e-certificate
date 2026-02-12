<?php

namespace App\Http\Controllers;

use App\Models\CertificateTemplate;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    /**
     * Halaman info sertifikat peserta
     */
    public function index()
    {
        $pesertaId = session('peserta_id');

        if (!$pesertaId) {
            return redirect('/absensi');
        }

        $peserta = Peserta::findOrFail($pesertaId);

        return view('sertifikat', [
            'nama'         => $peserta->nama_peserta,
            'noSertifikat' => 'CERT-' . str_pad($peserta->id, 5, '0', STR_PAD_LEFT),
        ]);
    }

    /**
     * Download sertifikat PDF
     */
    public function download()
    {
        // ===============================
        // VALIDASI SESSION PESERTA
        // ===============================
        $pesertaId = session('peserta_id');

        if (!$pesertaId) {
            return redirect('/absensi');
        }

        $peserta = Peserta::findOrFail($pesertaId);

        // ===============================
        // AMBIL TEMPLATE AKTIF (WAJIB)
        // ===============================
        $template = CertificateTemplate::where('is_active', true)->first();

        if (!$template) {
            return redirect()
                ->route('sertifikat.index')
                ->with('error', 'Sertifikat belum tersedia. Silakan hubungi panitia.');
        }

        // ===============================
        // VALIDASI FILE TEMPLATE
        // ===============================
        $imagePath = public_path('certificates/' . $template->file_name);

        if (!file_exists($imagePath)) {
            abort(500, 'File template sertifikat tidak ditemukan.');
        }

        // ===============================
        // LOAD IMAGE KE BASE64
        // ===============================
        $imageBase64 = base64_encode(file_get_contents($imagePath));
        $imageMime   = mime_content_type($imagePath);

        // ===============================
        // AMANKAN UKURAN CANVAS PDF
        // (TIDAK HARDCODE)
        // ===============================
        $width  = $template->width_px  ?: 1920;
        $height = $template->height_px ?: 1080;

        // ===============================
        // GENERATE PDF
        // ===============================
        $pdf = Pdf::loadView('sertifikat_pdf', [
            'nama'         => $peserta->nama_peserta,
            'noSertifikat' => 'CERT-' . str_pad($peserta->id, 5, '0', STR_PAD_LEFT),
            'template'     => $template,
            'imageBase64'  => $imageBase64,
            'imageMime'    => $imageMime,
        ])->setPaper('a4', 'landscape');


        // ===============================
        // DOWNLOAD FILE
        // ===============================
        return $pdf->download(
            'sertifikat_' . str_replace(' ', '_', strtolower($peserta->nama_peserta)) . '.pdf'
        );
    }
}
