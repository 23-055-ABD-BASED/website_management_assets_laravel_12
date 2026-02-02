<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'nip_pegawai',
        'nama_pegawai',
        'bidang_kerja',
        'jabatan',
        'status_pegawai',
        'id_pengguna',
    ];

    // ===============================
    // RELASI KE USER
    // ===============================
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_pengguna',
            'id'
        );
    }

    // ===============================
    // RELASI KE PEMINJAMAN (INI YANG KURANG)
    // ===============================
    public function peminjaman(): HasMany
    {
        return $this->hasMany(
            Peminjaman::class,
            'id_pegawai',
            'id_pegawai'
        );
    }
}
