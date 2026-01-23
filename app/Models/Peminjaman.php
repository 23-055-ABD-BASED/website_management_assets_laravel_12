<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // Fitur penanda aset digunakan dalam jangka panjang
    public function getDigunakanTerlaluLamaAttribute()
{
    $batasHari = 30;

    if ($this->status !== 'disetujui') {
        return false;
    }

    if (!$this->tanggal_pinjam || !$this->tanggal_kembali) {
        return false;
    }

    // HITUNG TOTAL DURASI PEMINJAMAN
    $durasi = Carbon::parse($this->tanggal_pinjam)
        ->diffInDays(Carbon::parse($this->tanggal_kembali));

    return $durasi >= $batasHari;
}

}
