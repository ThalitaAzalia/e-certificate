<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Webinar;
use App\Models\Peserta;
use App\Models\EvaluasiQuestion;
use App\Models\EvaluasiAnswer;
use App\Exports\EvaluasiExport;

class EvaluasiRatingConsistencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_peserta_rata_rating_and_export_are_consistent()
    {
        // create questions (rating)
        $q1 = EvaluasiQuestion::create(['question' => 'Q1', 'type' => 'rating', 'urutan' => 1]);
        $q2 = EvaluasiQuestion::create(['question' => 'Q2', 'type' => 'rating', 'urutan' => 2]);
        $q3 = EvaluasiQuestion::create(['question' => 'Q3', 'type' => 'rating', 'urutan' => 3]);

        // create webinar
        $w = Webinar::create(['judul' => 'W', 'deskripsi' => '', 'tanggal' => now()]);

        // peserta 1 with ratings 3,4,5 -> avg 4.00
        $p1 = Peserta::create(['webinar_id' => $w->id, 'nama_peserta' => 'P1', 'email' => 'p1@example.com']);
        EvaluasiAnswer::create(['peserta_id' => $p1->id, 'webinar_id' => $w->id, 'evaluasi_question_id' => $q1->id, 'answer' => 3]);
        EvaluasiAnswer::create(['peserta_id' => $p1->id, 'webinar_id' => $w->id, 'evaluasi_question_id' => $q2->id, 'answer' => 4]);
        EvaluasiAnswer::create(['peserta_id' => $p1->id, 'webinar_id' => $w->id, 'evaluasi_question_id' => $q3->id, 'answer' => 5]);

        $this->assertEquals(4.00, $p1->rataRating());

        // peserta 2 with ratings 5,5,5 -> avg 5.00
        $p2 = Peserta::create(['webinar_id' => $w->id, 'nama_peserta' => 'P2', 'email' => 'p2@example.com']);
        EvaluasiAnswer::create(['peserta_id' => $p2->id, 'webinar_id' => $w->id, 'evaluasi_question_id' => $q1->id, 'answer' => 5]);
        EvaluasiAnswer::create(['peserta_id' => $p2->id, 'webinar_id' => $w->id, 'evaluasi_question_id' => $q2->id, 'answer' => 5]);
        EvaluasiAnswer::create(['peserta_id' => $p2->id, 'webinar_id' => $w->id, 'evaluasi_question_id' => $q3->id, 'answer' => 5]);

        $this->assertEquals(5.00, $p2->rataRating());

        // EvaluasiExport should report same rata-rata per peserta
        $export = new EvaluasiExport($w->id, null, null);
        $rows = $export->collection();

        $rowP1 = $rows->firstWhere('Email', 'p1@example.com');
        $rowP2 = $rows->firstWhere('Email', 'p2@example.com');

        $this->assertEquals(4.00, (float) $rowP1['Rata-rata Rating']);
        $this->assertEquals(5.00, (float) $rowP2['Rata-rata Rating']);

        // Webinar average should be average of peserta averages = (4 + 5)/2 = 4.5
        $pesertas = Peserta::where('webinar_id', $w->id)->with('evaluasiAnswers.question')->get();
        $ratingsPeserta = $pesertas->map(fn($p) => $p->rataRating())->filter();
        $avg = $ratingsPeserta->count() ? round($ratingsPeserta->avg(), 2) : 0;

        $this->assertEquals(4.5, $avg);
    }
}
