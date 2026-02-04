<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public string $message;
    public int $receiverId;
    public string $senderName;

    public function __construct(string $message, int $receiverId, string $senderName)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
        $this->senderName = $senderName;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->receiverId);
    }
    public function broadcastAs()
    {
        return 'ChatMessageSent';
    }
}
