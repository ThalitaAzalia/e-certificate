<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'username',
        'name',
        'password',
        'photo',
    ];

    /**
     * Kolom tersembunyi
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attribute
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Override default login field
     * Laravel default = email
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function photoUrl()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : null;
    }

}
