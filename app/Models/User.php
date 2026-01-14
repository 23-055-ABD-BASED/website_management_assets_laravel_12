<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pegawai; // 🔥 WAJIB

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    /**
     * Kolom untuk autentikasi (override default 'email')
     */
    // public function getAuthIdentifierName()
    // {
    //     return 'username';
    // }

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke pegawai
     */
   public function pegawai()
{
    return $this->hasOne(
        Pegawai::class,
        'id_pengguna', // FK di tabel pegawai
        'id'           // PK di tabel users
    );
}

}
