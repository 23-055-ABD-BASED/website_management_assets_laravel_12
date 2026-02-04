<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatSupport extends Component
{
    /**
     * ================================
     * STATE
     * ================================
     */
    public $messageText = '';
    public $adminId;

    protected $rules = [
        'messageText' => 'required|string|max:1000',
    ];

    /**
     * ================================
     * INIT
     * ================================
     */
    public function mount()
    {
        // Ambil 1 admin (asumsi 1 admin utama)
        $this->adminId = User::where('role', 'admin')->value('id');

        if (!$this->adminId) {
            abort(500, 'Admin belum tersedia');
        }

        // Tandai pesan ADMIN → USER sebagai dibaca saat halaman dibuka
        Message::where('user_id', Auth::id())
            ->where('sender_id', $this->adminId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
    }

    /**
     * ================================
     * AMBIL PESAN (USER ↔ ADMIN)
     * ================================
     */
    public function getMessagesProperty()
    {
        $userId = Auth::id();

        return Message::where(function ($q) use ($userId) {
                // ADMIN → USER
                $q->where('sender_id', $this->adminId)
                  ->where('user_id', $userId);
            })
            ->orWhere(function ($q) use ($userId) {
                // USER → ADMIN
                $q->where('sender_id', $userId)
                  ->where('user_id', $this->adminId);
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * ================================
     * KIRIM PESAN (USER → ADMIN)
     * ================================
     */
    public function sendMessage()
    {
        $this->validate();

        Message::create([
            'sender_id' => Auth::id(),     // USER (pengirim)
            'user_id'   => $this->adminId, // ADMIN (penerima)
            'message'   => $this->messageText,
            'is_read'   => 0,
        ]);

        $this->reset('messageText');

        $this->dispatch('chat-scrolled');
    }

    public function render()
    {
        return view('livewire.chat-support', [
            'messages' => $this->messages,
        ]);
    }
}
