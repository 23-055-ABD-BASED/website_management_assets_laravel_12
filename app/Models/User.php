<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Pegawai;
use App\Models\Message;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * ================================
     * MASS ASSIGNABLE
     * ================================
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * ================================
     * HIDDEN
     * ================================
     */
    protected $hidden = [
        'password',
    ];

    /**
     * ================================
     * CASTS
     * ================================
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * ================================
     * ROLE HELPER
     * ================================
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * ================================
     * RELASI CHAT (BENAR & FINAL)
     * ================================
     */

    // Pesan DITERIMA (receiver)
        public function messagesReceived()
        {
            return $this->hasMany(Message::class, 'user_id');
        }

        // Pesan DIKIRIM (sender)
        public function messagesSent()
        {
            return $this->hasMany(Message::class, 'sender_id');
        }

        // Pesan BELUM DIBACA (badge)
        public function unreadMessages()
        {
            return $this->hasMany(Message::class, 'user_id')
                ->where('is_read', 0);
        }


    /**
     * ================================
     * RELASI PEGAWAI
     * ================================
     */
    public function pegawai(): HasOne
    {
        return $this->hasOne(
            Pegawai::class,
            'id_pengguna',
            'id'
        );
    }

    /**
     * ================================
     * CEK PEGAWAI AKTIF
     * ================================
     */
    public function isPegawaiAktif(): bool
    {
        if (!$this->pegawai) {
            return false;
        }

        return $this->pegawai->status_pegawai === 'aktif';
    }
}
