<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EvaluasiAnswer;
class Webinar extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'waktu',
        'narasumber',
        'media',
        'status',
        'poster',
        'link_absensi',
        'link_detail',
    ];

    /**
     * RELATION: Webinar -> Peserta
     */
    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }

    /**
     * RELATION: Webinar -> Evaluasi Answer
     */
    public function evaluasiAnswers()
    {
        return $this->hasMany(EvaluasiAnswer::class);
    }
}
