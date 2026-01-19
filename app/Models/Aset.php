<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $table = 'aset';
    protected $primaryKey = 'id_aset';

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'kategori_aset',
        'kondisi_aset',
        'status_aset',
    ];
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_aset', 'id_aset');
    }
}
