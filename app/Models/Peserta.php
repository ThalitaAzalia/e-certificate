<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'pesertas';

    protected $fillable = [
        'webinar_id',
        'nama_peserta',
        'email',
        'no_hp',
        'waktu_absen',
    ];

    public $timestamps = true;

    /**
     * RELATION: Peserta -> Webinar
     */
    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

    /**
     * RELATION: Peserta -> Evaluasi Answer
     */
    public function evaluasiAnswers()
    {
        return $this->hasMany(EvaluasiAnswer::class);
    }

    /**
     * HITUNG RATA-RATA RATING PESERTA (BISA DIPANGGIL DARI MANA SAJA)
     * Mengembalikan float (2 desimal) atau null jika tidak ada rating valid.
     */
    public function rataRating()
    {
        // Ambil ID pertanyaan bertipe rating (cache statis per request)
        static $ratingQuestionIds = null;

        if ($ratingQuestionIds === null) {
            $ratingQuestionIds = \App\Models\EvaluasiQuestion::where('type', 'rating')
                ->pluck('id')
                ->toArray();
        }

        $answers = $this->evaluasiAnswers()->whereIn('evaluasi_question_id', $ratingQuestionIds)->get();

        $ratings = $answers->pluck('answer')
            ->map(fn ($v) => (int) $v)
            ->filter(fn ($v) => $v >= 1 && $v <= 5);

        return $ratings->count()
            ? round($ratings->avg(), 2)
            : null;
    }
}
