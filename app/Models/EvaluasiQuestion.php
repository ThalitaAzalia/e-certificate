<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluasiQuestion extends Model
{
    protected $table = 'evaluasi_questions';

    protected $fillable = [
        'question',
        'type',
        'urutan',
    ];
}
