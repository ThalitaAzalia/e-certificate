<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EvaluasiQuestion;
use App\Models\EvaluasiAnswer;
use App\Models\Peserta;

class EvaluasiController extends Controller
{
    /**
     * ======================================
     * TAMPILKAN FORM EVALUASI
     * ======================================
     */
    public function index()
    {
        // 1. ambil session absensi
        $email     = session('email');
        $webinarId = session('webinar_id');

        // 2. wajib lewat absensi
        if (!$email || !$webinarId) {
            return redirect('/absensi')
                ->with('error', 'Silakan isi absensi terlebih dahulu.');
        }

        // 3. CEK: email + webinar sudah evaluasi?
        $sudahIsi = EvaluasiAnswer::where('webinar_id', $webinarId)
            ->whereHas('peserta', function ($q) use ($email) {
                $q->where('email', $email);
            })
            ->exists();

        if ($sudahIsi) {
            abort(403, 'Evaluasi sudah pernah diisi.');
        }

        // 4. tampilkan pertanyaan
        $questions = EvaluasiQuestion::orderBy('urutan')->get();

        return view('evaluasi', compact('questions'));
    }

    /**
     * ======================================
     * SIMPAN JAWABAN EVALUASI
     * ======================================
     */
    public function store(Request $request)
    {
        // 1. ambil session
        $pesertaId = session('peserta_id');
        $email     = session('email');
        $webinarId = session('webinar_id');

        if (!$pesertaId || !$email || !$webinarId) {
            abort(403, 'Akses tidak valid.');
        }

        // 2. DOUBLE CHECK (ANTI BYPASS)
        $sudahIsi = EvaluasiAnswer::where('webinar_id', $webinarId)
            ->whereHas('peserta', function ($q) use ($email) {
                $q->where('email', $email);
            })
            ->exists();

        if ($sudahIsi) {
            abort(403, 'Evaluasi sudah pernah diisi.');
        }

        // 3. simpan jawaban
        foreach ($request->answers as $questionId => $answer) {
            EvaluasiAnswer::create([
                'peserta_id'            => $pesertaId,
                'webinar_id'            => $webinarId,
                'evaluasi_question_id'  => $questionId,
                'answer'                => $answer,
            ]);
        }

        return redirect('/sertifikat')
            ->with('success', 'Terima kasih, evaluasi berhasil dikirim.');
    }
}
