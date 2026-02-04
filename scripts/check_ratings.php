<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Webinar;
use App\Exports\EvaluasiExport;

$webinars = Webinar::has('pesertas')->get();

if ($webinars->isEmpty()) {
    echo "No webinars with peserta found.\n";
    exit(0);
}

foreach ($webinars as $w) {
    echo "Webinar: {$w->id} - {$w->judul}\n";

    $export = new EvaluasiExport($w->id, null, null);
    $rows = $export->collection();

    $pesertas = $w->pesertas()->with('evaluasiAnswers')->get();

    $diffs = 0;

    foreach ($pesertas as $p) {
        $modelRating = $p->rataRating();

        $row = $rows->firstWhere('Email', $p->email);
        $exportRating = $row ? ($row['Rata-rata Rating'] === '-' ? null : (float) $row['Rata-rata Rating']) : null;

        if ($modelRating !== $exportRating) {
            echo "  Peserta {$p->id} ({$p->email}): model={$modelRating} export={$exportRating}\n";
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
        echo "  Webinar avg mismatch: model={$avgModel} export={$avgExport}\n";
        $diffs++;
    }

    if ($diffs === 0) {
        echo "  OK — all consistent\n";
    }

    echo "\n";
}
