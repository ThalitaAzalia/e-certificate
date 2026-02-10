<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\EvaluasiAnswer;
use App\Models\Webinar;

class DashboardController extends Controller
{
    public function index()
    {
        // WEBINAR DENGAN PESERTA COUNT
        $webinars = Webinar::withCount('pesertas')
                            ->orderBy('created_at', 'desc')
                            ->get();

        // HITUNG 1 PESERTA = 1 EVALUASI
        $totalEvaluasi = EvaluasiAnswer::distinct('peserta_id')
                            ->count('peserta_id');

        // Asumsi sertifikat terbit setelah evaluasi
        $totalSertifikat = $totalEvaluasi;

        // TOTAL PESERTA
        $totalPeserta = Peserta::count();

        return view('admin.dashboard', compact(
            'webinars',
            'totalEvaluasi',
            'totalSertifikat',
            'totalPeserta'
        ));
    }

    /**
     * GET PESERTA PER WEBINAR (API)
     */
    public function getPesertaWebinar($webinarId)
    {
        try {
            $webinar = Webinar::find($webinarId);
            
            if (!$webinar) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Webinar tidak ditemukan'
                ], 404);
            }

            $pesertas = Peserta::where('webinar_id', $webinar->id)
                                ->select('id', 'nama_peserta', 'email', 'no_hp', 'waktu_absen')
                                ->get();

            return response()->json([
                'status' => 'success',
                'pesertas' => $pesertas
            ]);
        } catch (\Exception $e) {
            \Log::error('getPesertaWebinar error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE PESERTA
     */
    public function deletePeserta($pesertaId)
    {
        $peserta = Peserta::find($pesertaId);
        
        if (!$peserta) {
            return response()->json([
                'status' => 'error',
                'message' => 'Peserta tidak ditemukan'
            ], 404);
        }

        try {
            // Hapus evaluasi jawaban peserta ini terlebih dahulu
            EvaluasiAnswer::where('peserta_id', $peserta->id)->delete();
            
            // Hapus peserta
            $peserta->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data peserta berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE SEMUA PESERTA PER WEBINAR
     */
    public function deleteWebinarPeserta($webinarId)
    {
        $webinar = Webinar::find($webinarId);
        
        if (!$webinar) {
            return response()->json([
                'status' => 'error',
                'message' => 'Webinar tidak ditemukan'
            ], 404);
        }

        try {
            // Ambil semua peserta di webinar ini
            $pesertas = Peserta::where('webinar_id', $webinar->id)->get();
            
            // Hapus evaluasi jawaban mereka
            foreach ($pesertas as $peserta) {
                EvaluasiAnswer::where('peserta_id', $peserta->id)->delete();
                $peserta->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Semua data peserta webinar berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}



