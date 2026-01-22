<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EvaluasiQuestion;

class EvaluasiAnswer extends Model
{
    use HasFactory;

    protected $table = 'evaluasi_answers';

    protected $fillable = [
    'peserta_id',
    'webinar_id',
    'evaluasi_question_id',
    'answer',
    ];

    public function question()
    {
        return $this->belongsTo(EvaluasiQuestion::class, 'evaluasi_question_id');
    }
    public $timestamps = true;

    /**
     * RELATION: EvaluasiAnswer -> Peserta
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    /**
     * RELATION: EvaluasiAnswer -> Webinar
     */
    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }
}
