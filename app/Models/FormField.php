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

    // ✅ ICON DIPANGGIL DARI FORM DATA DIRI & FORM EVALUASI
    public function icon()
    {
        return match ($this->type) {
            'email'    => 'mail',
            'tel'      => 'phone',
            'number'   => 'hash',
            'date'     => 'calendar',
            'textarea' => 'note',
            default    => 'user',
        };
    }

    // ✅ PLACEHOLDER DINAMIS, TIDAK HARD FIELD
    public function placeholderText()
    {
        if (!empty($this->placeholder)) {
            return $this->placeholder;
        }

        $label = strtolower($this->label ?? '');
        $key   = strtolower($this->field_key ?? '');

        if ($this->type === 'email' || str_contains($label, 'email') || str_contains($key, 'email')) {
            return 'Masukkan email aktif';
        }

        if ($this->type === 'tel' || str_contains($label, 'hp') || str_contains($label, 'handphone')) {
            return 'Contoh: 08xxxxxxxxxxx';
        }

        if (str_contains($label, 'nama') || str_contains($key, 'nama')) {
            return 'Masukkan nama lengkap';
        }

        return '';
    }
        public function getPlaceholderAttribute()
    {
        if (!empty($this->attributes['placeholder'])) {
            return $this->attributes['placeholder'];
        }

        if (!empty($this->attributes['admin_note'])) {
            return $this->attributes['admin_note'];
        }

        return '';
    }

}
