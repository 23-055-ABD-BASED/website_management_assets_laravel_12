<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
| File ini mendefinisikan semua channel realtime (WebSocket / Echo)
| yang digunakan aplikasi (chat, notifikasi, dll)
|
*/

/**
 * ============================================
 * PRIVATE CHAT CHANNEL (ADMIN & USER)
 * ============================================
 *
 * Channel  : chat.{id}
 * Akses   : hanya user dengan ID sesuai
 * Digunakan untuk:
 * - Realtime chat
 * - Popup notifikasi (admin & user)
 */
Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * ============================================
 * (OPSIONAL) PRESENCE CHANNEL – JIKA MAU
 * ============================================
 * Digunakan untuk:
 * - Online / offline status
 * - Typing indicator
 *
 * Aktifkan hanya jika diperlukan
 */
/*
Broadcast::channel('chat-presence', function ($user) {
    return [
        'id'       => $user->id,
        'name'     => $user->username,
        'role'     => $user->role,
    ];
});
*/
