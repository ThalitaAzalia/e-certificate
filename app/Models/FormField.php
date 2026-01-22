<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $table = 'form_fields';

    protected $fillable = [
        'field_key',
        'label',
        'type',
        'required',
        'active',
        'sort_order',
        'placeholder',
        'admin_note',
    ];

    protected $casts = [
        'required' => 'boolean',
        'active'   => 'boolean',
    ];
}
