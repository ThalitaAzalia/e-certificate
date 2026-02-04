<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EvaluasiExport implements FromCollection, WithHeadings
{
    protected $webinarId;
    protected $startDate;
    protected $endDate;

    public function __construct($webinarId, $startDate, $endDate)
    {
        $this->webinarId = $webinarId;
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function collection(): Collection
    {
        $query = Peserta::with(['webinar', 'evaluasiAnswers.question']);

        // FILTER WEBINAR
        if ($this->webinarId) {
            $query->where('webinar_id', $this->webinarId);
        }

        // FILTER TANGGAL
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate,
                $this->endDate
            ]);
        }

        return $query->get()->map(function ($p) {

            $rating = $p->rataRating();

            return [
                'Nama Peserta' => $p->nama_peserta,
                'Email'        => $p->email,
                'Webinar'      => $p->webinar->judul ?? '-',
                'Tanggal Isi'  => optional($p->created_at)->format('d-m-Y H:i'),
                'Rata-rata Rating' => $rating !== null ? round($rating, 2) : '-',
                'Komentar' => $p->evaluasiAnswers
                    ->whereNotNull('answer')
                    ->pluck('answer')
                    ->implode(' | '),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Peserta',
            'Email',
            'Webinar',
            'Tanggal Isi',
            'Rata-rata Rating',
            'Komentar',
        ];
    }
}
