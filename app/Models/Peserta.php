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
}
