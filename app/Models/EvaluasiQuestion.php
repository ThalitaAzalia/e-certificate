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
        'rating_min',
        'rating_max',
        'rating_labels',
    ];

    protected $casts = [
        'rating_labels' => 'array',
    ];
}
