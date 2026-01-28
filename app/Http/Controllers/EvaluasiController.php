<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluasiQuestion;
use App\Models\EvaluasiAnswer;

class EvaluasiController extends Controller
{
    /**
     * TAMPILKAN FORM EVALUASI KE PESERTA
     */
    public function index()
    {
        $questions = EvaluasiQuestion::orderBy('urutan')->paginate(10);

        return view('evaluasi', compact('questions'));
    }

    /**
     * SIMPAN JAWABAN EVALUASI
     */
    public function store(Request $request)
    {
    // ============================
        // 1. VALIDASI SESSION ABSENSI
        // ============================
        $pesertaId = session('peserta_id');
        $webinarId = session('webinar_id');

        if (!$pesertaId || !$webinarId) {
            abort(403, 'Akses tidak valid. Silakan isi absensi terlebih dahulu.');
        }

        // ============================
        // 2. CEGAH EVALUASI GANDA
        // ============================
        $sudahIsi = \App\Models\EvaluasiAnswer::where('peserta_id', $pesertaId)
            ->where('webinar_id', $webinarId)
            ->exists();

        if ($sudahIsi) {
            abort(403, 'Evaluasi sudah pernah diisi.');
        }

        // ============================
        // 3. SIMPAN JAWABAN (ASLI)
        // ============================
        foreach ($request->answers as $questionId => $answer) {
            \App\Models\EvaluasiAnswer::create([
                'peserta_id' => $pesertaId,
                'webinar_id' => $webinarId,
                'evaluasi_question_id' => $questionId,
                'answer' => $answer,
            ]);
        }

        return redirect('/sertifikat');
    }
}
