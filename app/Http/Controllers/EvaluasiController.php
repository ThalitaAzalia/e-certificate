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
        $questions = EvaluasiQuestion::orderBy('urutan')->get();

        return view('evaluasi', compact('questions'));
    }

    /**
     * SIMPAN JAWABAN EVALUASI
     */
    public function store(Request $request)
{
    $pesertaId = session('peserta_id');
    $webinarId = session('webinar_id'); // ⬅️ INI YANG KURANG

    // pengaman (optional tapi sangat disarankan)
    if (!$pesertaId || !$webinarId) {
        return redirect('/absensi')
            ->withErrors('Session habis. Silakan isi absensi ulang.');
    }

    foreach ($request->answers as $questionId => $answer) {
        $question = EvaluasiQuestion::find($questionId);
        if (!$question) continue;

        EvaluasiAnswer::create([
            'peserta_id'            => $pesertaId,
            'webinar_id'            => $webinarId, // ✅ SEKARANG ADA
            'evaluasi_question_id'  => $question->id,
            'answer'                => $answer,
        ]);
    }

    return redirect('/sertifikat')
        ->with('success', 'Evaluasi berhasil dikirim. Terima kasih 🙏');
}
}
