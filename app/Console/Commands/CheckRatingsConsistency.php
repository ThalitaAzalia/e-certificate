<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Webinar;
use App\Exports\EvaluasiExport;

class CheckRatingsConsistency extends Command
{
    protected $signature = 'check:ratings';
    protected $description = 'Check rating calculation consistency across model, export, and summary';

    public function handle()
    {
        $webinars = Webinar::has('pesertas')->get();

        foreach ($webinars as $w) {
            $this->info("Webinar: {$w->id} - {$w->judul}");

            $export = new EvaluasiExport($w->id, null, null);
            $rows = $export->collection();

            $pesertas = $w->pesertas()->with('evaluasiAnswers')->get();

            $diffs = 0;

            foreach ($pesertas as $p) {
                $modelRating = $p->rataRating();

                $row = $rows->firstWhere('Email', $p->email);
                $exportRating = $row ? ($row['Rata-rata Rating'] === '-' ? null : (float) $row['Rata-rata Rating']) : null;

                if ($modelRating !== $exportRating) {
                    $this->line("  Peserta {$p->id} ({$p->email}): model={$modelRating} export={$exportRating}");
                    $diffs++;
                }
            }

            // webinar average
            $ratingsPeserta = $pesertas->map(fn($p) => $p->rataRating())->filter();
            $avgModel = $ratingsPeserta->count() ? round($ratingsPeserta->avg(), 2) : 0;

            // avg from export
            $exportRatings = $rows->pluck('Rata-rata Rating')->filter(fn($v) => $v !== '-')->map(fn($v) => (float) $v);
            $avgExport = $exportRatings->count() ? round($exportRatings->avg(), 2) : 0;

            if ($avgModel !== $avgExport) {
                $this->line("  Webinar avg mismatch: model={$avgModel} export={$avgExport}");
                $diffs++;
            }

            if ($diffs === 0) {
                $this->info('  OK — all consistent');
            }

            $this->line('');
        }

        return 0;
    }
}
