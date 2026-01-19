<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $guarded = ['id'];

    // Relasi ke Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    // Relasi ke Aset
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'id_aset', 'id_aset');
    }
}