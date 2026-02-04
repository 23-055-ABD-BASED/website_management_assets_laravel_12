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

    /**
     * =========================
     * KONSTANTA (ANTI TYPO)
     * =========================
     */
    public const KONDISI_BAIK  = 'baik';
    public const KONDISI_RUSAK = 'rusak';

    public const STATUS_TERSEDIA  = 'tersedia';
    public const STATUS_DIGUNAKAN = 'digunakan';
    public const STATUS_RUSAK     = 'rusak';

    /**
     * =========================
     * RELATION
     * =========================
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_aset', 'id_aset');
    }

    /**
     * =========================
     * HELPER LOGIC
     * =========================
     */

    public function isTersedia(): bool
    {
        return $this->status_aset === self::STATUS_TERSEDIA
            && $this->kondisi_aset === self::KONDISI_BAIK;
    }

    public function isRusak(): bool
    {
        return $this->kondisi_aset === self::KONDISI_RUSAK;
    }

    public function isDigunakan(): bool
    {
        return $this->status_aset === self::STATUS_DIGUNAKAN;
    }

    /**
     * =========================
     * QUERY SCOPES (OPSIONAL TAPI PRO)
     * =========================
     */
    public function scopeTersedia($query)
    {
        return $query->where('status_aset', self::STATUS_TERSEDIA)
                     ->where('kondisi_aset', self::KONDISI_BAIK);
    }

    public function scopeRusak($query)
    {
        return $query->where('kondisi_aset', self::KONDISI_RUSAK);
    }
}