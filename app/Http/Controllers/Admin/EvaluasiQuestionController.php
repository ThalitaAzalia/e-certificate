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
            'question'    => 'required|string|max:255',
            'type'        => 'required|in:rating,text,textarea',
            'urutan'      => 'required|integer|min:1',
            'rating_max'  => 'nullable|integer|min:2|max:10',
            'rating_labels' => 'nullable|array',
        ]);

        $data = $request->only(['question', 'type', 'urutan']);

        // KHUSUS PERTANYAAN RATING
        if ($question->type === 'rating') {
            $data['rating_min'] = 1;
            $data['rating_max'] = $request->rating_max ?? $question->rating_max;

            if ($request->filled('rating_labels')) {
                $data['rating_labels'] = array_filter(
                    $request->rating_labels,
                    fn ($v) => $v !== null && $v !== ''
                );
            }
        }

        $question->update($data);

        return redirect()->back()
            ->with('success', 'Skala & label rating berhasil disimpan');
    }

    public function updateScale(Request $request, EvaluasiQuestion $question)
    {
        $request->validate([
            'rating_max'    => 'required|integer|min:2|max:10',
            'rating_labels'=> 'nullable|array',
        ]);

        if ($question->type !== 'rating') {
            abort(400, 'Bukan pertanyaan rating');
        }

        $question->update([
            'rating_min'    => 1,
            'rating_max'    => $request->rating_max,
            'rating_labels' => array_filter(
                $request->rating_labels ?? [],
                fn ($v) => $v !== null && $v !== ''
            ),
        ]);

        return redirect()->back()
            ->with('success', 'Skala rating berhasil diperbarui');
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
