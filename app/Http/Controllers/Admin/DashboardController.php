<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\EvaluasiAnswer;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeserta = Peserta::count();

        // HITUNG 1 PESERTA = 1 EVALUASI
        $totalEvaluasi = EvaluasiAnswer::distinct('peserta_id')
                            ->count('peserta_id');

        // Asumsi sertifikat terbit setelah evaluasi
        $totalSertifikat = $totalEvaluasi;

        return view('admin.dashboard', compact(
            'totalPeserta',
            'totalEvaluasi',
            'totalSertifikat'
        ));
    }
}
