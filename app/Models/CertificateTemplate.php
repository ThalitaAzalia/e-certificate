<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = [
    'name',
    'file_name',
    'is_active',

    // box teks
    'box_x',
    'box_y',
    'box_width',
    'box_height',

    // font
    'font_family',
    'font_size',
    'font_color',
    'font_weight',
    'font_style',
    'letter_spacing',
    'line_height',
    'text_align',

    // ukuran template
    'width_px',
    'height_px',
];

}

