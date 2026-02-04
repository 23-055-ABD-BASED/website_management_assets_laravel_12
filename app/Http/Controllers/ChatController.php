<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function checkNewMessages()
    {
        try {
            $latest = Message::with('sender')
                ->where('user_id', Auth::id()) // Pesan ditujukan ke saya
                ->where('is_read', 0)
                ->latest()
                ->first();

            if ($latest) {
                return response()->json([
                    'new_message'  => true,
                    'message_id'   => $latest->id,
                    'sender_name'  => $latest->sender->username ?? 'User',
                    'message_text' => Str::limit($latest->message, 45)
                ]);
            }
            return response()->json(['new_message' => false]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}