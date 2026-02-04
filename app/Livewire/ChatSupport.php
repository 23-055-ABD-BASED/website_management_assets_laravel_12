<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatSupport extends Component
{
    public $messageText = '';
    public $adminId;

    // KUNCI: simpan pesan terakhir
    public $lastMessageId = null;

    protected $rules = [
        'messageText' => 'required|string|max:1000',
    ];

    public function mount()
    {
        $this->adminId = User::where('role', 'admin')->value('id');

        if (!$this->adminId) {
            abort(500, 'Admin belum tersedia');
        }

        // set lastMessageId awal
        $last = Message::where(function ($q) {
                $q->where('sender_id', Auth::id())
                  ->where('user_id', $this->adminId);
            })
            ->orWhere(function ($q) {
                $q->where('sender_id', $this->adminId)
                  ->where('user_id', Auth::id());
            })
            ->latest('id')
            ->first();

        $this->lastMessageId = $last?->id;
    }

    public function getMessagesProperty()
    {
        $userId = Auth::id();

        return Message::where(function ($q) use ($userId) {
                $q->where('sender_id', $this->adminId)
                  ->where('user_id', $userId);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('user_id', $this->adminId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage()
    {
        $this->validate();

        $msg = Message::create([
            'sender_id' => Auth::id(),
            'user_id'   => $this->adminId,
            'message'   => $this->messageText,
            'is_read'   => 0,
        ]);

        $this->lastMessageId = $msg->id;

        $this->reset('messageText');

        // kirim sendiri → force scroll
        $this->dispatch('chat-sent');
    }

    public function render()
    {
        // CEK APAKAH ADA PESAN BARU
        $latestId = Message::where(function ($q) {
                $q->where('sender_id', Auth::id())
                  ->where('user_id', $this->adminId);
            })
            ->orWhere(function ($q) {
                $q->where('sender_id', $this->adminId)
                  ->where('user_id', Auth::id());
            })
            ->latest('id')
            ->value('id');

        // HANYA DISPATCH JIKA BERUBAH
        if ($latestId && $latestId !== $this->lastMessageId) {
            $this->lastMessageId = $latestId;
            $this->dispatch('messages-updated');
        }

        return view('livewire.chat-support', [
            'messages' => $this->messages,
        ]);
    }
}
