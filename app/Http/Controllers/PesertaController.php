<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\FormField;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    // =========================
    // FORM ABSENSI (GET)
    // =========================
    public function create(Request $request)
    {
        // Ambil field yang aktif
        $fields = FormField::where('active', true)
            ->orderBy('sort_order')
            ->get();

        // Ambil webinar_id dari query string
        $webinarId = $request->query('webinar_id');

        // Kalau tidak ada webinar_id → jangan izinkan akses
        if (!$webinarId) {
            abort(404, 'Webinar tidak ditemukan');
        }

        return view('absensi', compact('fields', 'webinarId'));
    }

    // =========================
    // SIMPAN ABSENSI (POST)
    // =========================
    public function store(Request $request)
    {
        // Ambil field aktif
        $fields = FormField::where('active', true)->get();

        // =========================
        // VALIDASI DINAMIS
        // =========================
        $rules = [];

        foreach ($fields as $field) {
            $rule = [];

            $rule[] = $field->required ? 'required' : 'nullable';

            if ($field->type === 'email') {
                $rule[] = 'email';
            }

            $rules[$field->field_key] = implode('|', $rule);
        }

        // VALIDASI webinar_id (WAJIB & VALID)
        $rules['webinar_id'] = 'required|exists:webinars,id';

        $validated = $request->validate($rules);

        $email     = $validated['email'];
        $webinarId = $validated['webinar_id'];

        // cek apakah EMAIL INI sudah pernah evaluasi di webinar ini
        $sudahEvaluasi = \App\Models\EvaluasiAnswer::where('webinar_id', $webinarId)
            ->whereHas('peserta', function ($q) use ($email) {
                $q->where('email', $email);
            })
            ->exists();

        if ($sudahEvaluasi) {
            return back()->withErrors([
                'email' => 'Email ini sudah pernah mengisi evaluasi untuk webinar ini.'
            ]);
        }

        // =========================
        // SIMPAN PESERTA (DENGAN webinar_id)
        // =========================
        $peserta = Peserta::create([
            'webinar_id'   => $validated['webinar_id'], // ✅ FIX UTAMA
            'nama_peserta' => $validated['nama_peserta'] ?? null,
            'email'        => $validated['email'] ?? null,
            'no_hp'        => $validated['no_hp'] ?? null,
            'waktu_absen'  => now(),
        ]);

        // =========================
        // SIMPAN SESSION (UNTUK EVALUASI)
        // =========================
        session([
            'peserta_id'   => $peserta->id,
            'nama_peserta' => $peserta->nama_peserta,
            'email'        => $peserta->email,
            'webinar_id'   => $peserta->webinar_id,
        ]);

        return redirect('/evaluasi')
            ->with('success', 'Absensi berhasil, silakan isi evaluasi.');
    }
}
