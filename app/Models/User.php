<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pegawai;

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
     * ================================
     * RELASI KE PEGAWAI
     * ================================
     */
    public function pegawai()
    {
        return $this->hasOne(
            Pegawai::class,
            'id_pengguna', // FK di tabel pegawai
            'id'           // PK di tabel users
        );
    }

    /**
     * ================================
     * CEK APAKAH PEGAWAI AKTIF
     * ================================
     */
    public function isPegawaiAktif(): bool
    {
        // Jika user tidak punya data pegawai → dianggap TIDAK AKTIF
        if (!$this->pegawai) {
            return false;
        }

        // Cek status pegawai
        return $this->pegawai->status_pegawai === 'aktif';
    }
}
