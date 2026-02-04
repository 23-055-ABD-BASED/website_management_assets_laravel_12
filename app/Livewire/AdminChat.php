<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class AdminChat extends Component
{
    public $selectedUserId = null;
    public $messageText = '';
    public $search = '';

    protected $rules = [
        'messageText' => 'required|string|max:1000',
    ];

   public function getConversationsProperty()
{
    $adminId = Auth::id();

    return User::where(function ($q) {
            $q->whereNull('role')
              ->orWhere('role', '!=', 'admin');
        })
        ->when($this->search, fn ($q) =>
            $q->where('username', 'like', "%{$this->search}%")
        )
        ->withCount([
            // UNREAD = pesan USER → ADMIN
            'messagesSent as unread_count' => function ($q) use ($adminId) {
                $q->where('user_id', $adminId)
                  ->where('is_read', 0);
            }
        ])
        ->get()
        ->sortByDesc(function ($user) use ($adminId) {
            // Ambil pesan terakhir USER ↔ ADMIN
            return Message::where(function ($q) use ($user, $adminId) {
                    $q->where('sender_id', $user->id)
                      ->where('user_id', $adminId);
                })
                ->orWhere(function ($q) use ($user, $adminId) {
                    $q->where('sender_id', $adminId)
                      ->where('user_id', $user->id);
                })
                ->latest()
                ->value('created_at');
        });
}


    public function getMessagesProperty()
    {
        if (!$this->selectedUserId) return collect();

        // 1. Update status di database agar is_read jadi 1
        Message::where('user_id', Auth::id())
            ->where('sender_id', $this->selectedUserId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        // 2. Ambil chat dua arah
        return Message::where(function($q) {
                $q->where('user_id', $this->selectedUserId)->where('sender_id', Auth::id());
            })
            ->orWhere(function($q) {
                $q->where('user_id', Auth::id())->where('sender_id', $this->selectedUserId);
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->reset('messageText');
        
        // PAKSA REFRESH SIDEBAR: Buang data lama dari memori
        unset($this->conversations); 
        
        $this->dispatch('chat-scrolled');
    }

    public function sendMessage()
    {
        $this->validate();
        if (!$this->selectedUserId) return;

        Message::create([
            'user_id'   => $this->selectedUserId,
            'sender_id' => Auth::id(),
            'message'   => $this->messageText,
            'is_read'   => 0,
        ]);

        $this->reset('messageText');
        
        // Refresh sidebar agar pesan terbaru muncul di preview
        unset($this->conversations); 
        
        $this->dispatch('chat-scrolled');
    }

    public function render()
    {
        return view('livewire.admin-chat');
    }
}