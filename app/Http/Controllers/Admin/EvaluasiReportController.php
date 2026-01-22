<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Webinar;
use App\Models\EvaluasiQuestion;
use Illuminate\Http\Request;

class EvaluasiReportController extends Controller
{
    /**
     * =========================================================
     * INDEX LAPORAN (UI)
     * =========================================================
     */
    public function index(Request $request)
    {
        $webinarId = $request->query('webinar_id');
        $startDate = $request->query('start');
        $endDate   = $request->query('end');

        $query = Webinar::query();

        // FILTER TANGGAL
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        // FILTER WEBINAR
        if ($webinarId) {
            $query->where('id', $webinarId);
        }

        // ========================
        // HITUNG RATING (KONSISTEN)
        // ========================
        $webinars = $query->get()->map(function ($w) {

            $pesertas = Peserta::where('webinar_id', $w->id)
                ->with(['evaluasiAnswers.question'])
                ->get();

            $ratingsPeserta = $pesertas
                ->map(fn ($p) => $this->hitungRatingPeserta($p))
                ->filter();


            return (object) [
                'id'           => $w->id,
                'judul'        => $w->judul,
                'deskripsi'    => $w->deskripsi,
                'tanggal'      => $w->tanggal,
                'total_respon' => $pesertas->count(),
                'rata_rating'  => $ratingsPeserta->count()
                    ? round($ratingsPeserta->avg(), 2)
                    : 0,
            ];
        });

        // ========================
        // DATA GRAFIK (REAL)
        // ========================
        $chartLabels = $webinars->pluck('judul')->values();
        $chartRatings = $webinars->pluck('rata_rating')->values();

        $allWebinars = Webinar::orderBy('judul')->get();

        $totalRespon = $webinars->sum('total_respon');
        $avgRating   = $webinars->count()
            ? round($webinars->avg('rata_rating'), 2)
            : 0;

        return view(
        'admin.laporan-evaluasi',
        compact(
            'webinars',
            'allWebinars',
            'totalRespon',
            'avgRating',
            'webinarId',
            'startDate',
            'endDate',
            'chartLabels',
            'chartRatings'
        )
    );

    }

    /**
     * =========================================================
     * HALAMAN PESERTA PER WEBINAR
     * =========================================================
     */
    public function peserta(Webinar $webinar)
    {
        $pesertas = Peserta::where('webinar_id', $webinar->id)
            ->whereHas('evaluasiAnswers')
            ->with('evaluasiAnswers')
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'admin.laporan-evaluasi-peserta',
            compact('webinar', 'pesertas')
        );
    }

    /**
     * =========================================================
     * DETAIL EVALUASI SATU PESERTA
     * =========================================================
     */
    public function detail(Peserta $peserta)
    {
        $peserta->load(['webinar', 'evaluasiAnswers.question']);

        return view(
            'admin.laporan-evaluasi-detail',
            compact('peserta')
        );
    }

    /**
     * =========================================================
     * EXPORT (AUTO MODE)
     * =========================================================
     */
    public function export(Request $request)
    {
        $webinarId = $request->query('webinar_id');
        $startDate = $request->query('start');
        $endDate   = $request->query('end');

        if (!$webinarId) {
            return $this->exportRingkasanWebinar($startDate, $endDate);
        }

        return $this->exportDetailPeserta($webinarId, $startDate, $endDate);
    }

    /**
     * =========================================================
     * EXPORT RINGKASAN SEMUA WEBINAR
     * =========================================================
     */
    private function exportRingkasanWebinar($startDate, $endDate)
    {
        $query = Webinar::query();

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        $webinars = $query->get()->map(function ($w) {

            $ratingsPeserta = Peserta::where('webinar_id', $w->id)
                ->with(['evaluasiAnswers.question'])
                ->get()
                ->map(fn ($p) => $this->hitungRatingPeserta($p))
                ->filter();

            return (object) [
                'judul'        => $w->judul,
                'tanggal'      => $w->tanggal,
                'total_respon' => $ratingsPeserta->count(),
                'rata_rating'  => $ratingsPeserta->count()
                    ? round($ratingsPeserta->avg(), 2)
                    : 0,
            ];
        });

        $filename = 'ringkasan-evaluasi-webinar-' . now()->format('Ymd_His') . '.csv';

        return response()->stream(function () use ($webinars) {

            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'Webinar',
                'Periode',
                'Total Respon',
                'Rata-rata Rating'
            ]);

            foreach ($webinars as $i => $w) {
                fputcsv($file, [
                    $i + 1,
                    $this->safeCsv($w->judul),
                    \Carbon\Carbon::parse($w->tanggal)->format('M Y'),
                    $w->total_respon,
                    $w->rata_rating,
                ]);
            }

            fclose($file);

        }, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control'       => 'no-store, no-cache',
        ]);
    }

    /**
     * =========================================================
     * EXPORT DETAIL PESERTA (PER WEBINAR)
     * =========================================================
     */
    private function exportDetailPeserta($webinarId, $startDate, $endDate)
    {
        $questions = EvaluasiQuestion::orderBy('urutan')
            ->where('type', 'rating')
            ->get();

        $query = Peserta::with(['webinar', 'evaluasiAnswers.question'])
            ->where('webinar_id', $webinarId);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate   . ' 23:59:59',
            ]);
        }

        $pesertas = $query->get();

        $filename = 'detail-evaluasi-webinar-' . now()->format('Ymd_His') . '.csv';

        return response()->stream(function () use ($pesertas, $questions) {

            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // HEADER
            $headers = ['Nama Peserta','Email','Webinar','Tanggal Isi'];
            foreach ($questions as $q) $headers[] = $q->question;
            $headers[] = 'Komentar';
            $headers[] = 'Rating Peserta';

            fputcsv($file, $headers);

            $summaryRatings = [];

            foreach ($pesertas as $p) {

                $row = [
                    $this->safeCsv($p->nama_peserta),
                    $this->safeCsv($p->email),
                    $this->safeCsv(optional($p->webinar)->judul),
                    optional($p->created_at)->format('d-m-Y H:i'),
                ];

                // tampilkan jawaban rating per pertanyaan
                foreach ($questions as $q) {
                    $ans = $p->evaluasiAnswers
                        ->where('evaluasi_question_id', $q->id)
                        ->first();
                    $row[] = $ans->answer ?? '-';
                }

                // komentar
// ================= KOMENTAR (FINAL & AMAN) =================
                $komentar = $p->evaluasiAnswers
                    ->pluck('answer')
                    ->filter(function ($val) {
                        // ambil yang BENAR-BENAR komentar
                        return $val !== null
                            && $val !== ''
                            && !is_numeric($val);
                    })
                    ->implode(' | ');

                $row[] = $this->safeCsv($komentar);


                // rating peserta (SATU SUMBER)
                $ratingPeserta = $this->hitungRatingPeserta($p);
                if ($ratingPeserta !== null) $summaryRatings[] = $ratingPeserta;
                $row[] = $ratingPeserta ?? '-';

                fputcsv($file, $row);
            }

            // BARIS RATA-RATA
            $summaryRow = ['RATA-RATA','','',''];
            foreach ($questions as $q) $summaryRow[] = '';
            $summaryRow[] = ''; // komentar
            $summaryRow[] = count($summaryRatings)
                ? round(collect($summaryRatings)->avg(), 2)
                : '-';

            fputcsv($file, $summaryRow);
            fclose($file);

        }, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control'       => 'no-store, no-cache',
        ]);
    }

    /**
 * =========================================================
 * HELPER: HITUNG RATING PESERTA (FINAL & AMAN)
 * =========================================================
 */
    private function hitungRatingPeserta(\App\Models\Peserta $peserta)
    {
        // Ambil ID pertanyaan rating (1x, cache per request)
        static $ratingQuestionIds = null;

        if ($ratingQuestionIds === null) {
            $ratingQuestionIds = \App\Models\EvaluasiQuestion::where('type', 'rating')
                ->pluck('id')
                ->toArray();
        }

        $ratings = $peserta->evaluasiAnswers
            ->whereIn('evaluasi_question_id', $ratingQuestionIds)
            ->pluck('answer')
            ->map(fn ($v) => (int) $v)
            ->filter(fn ($v) => $v >= 1 && $v <= 5);

        return $ratings->count()
            ? round($ratings->avg(), 2)
            : null;
    }


    /**
     * =========================================================
     * HELPER CSV AMAN
     * =========================================================
     */
    private function safeCsv($value)
    {
        if ($value === null) return '';

        $value = (string) $value;

        if (preg_match('/^[=+\-@]/', $value)) {
            return "'" . $value;
        }

        return $value;
    }
}
