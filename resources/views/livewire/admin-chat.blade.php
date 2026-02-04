<div wire:poll.3s
    class="fixed inset-x-0 bottom-0 top-16 md:top-20 md:inset-4 z-10"
>
    <div class="flex h-full bg-slate-50
                rounded-none md:rounded-2xl shadow-2xl overflow-hidden">

        {{-- ================= SIDEBAR ================= --}}
        <aside
            class="
                bg-white border-r
                w-full md:w-[360px]
                flex flex-col
                transition-all duration-300
                {{ $selectedUserId ? 'hidden md:flex' : 'flex' }}
            ">

            {{-- Header --}}
            <div class="h-16 px-4 flex items-center bg-white border-b">
                <h2 class="font-extrabold text-xl">Messages</h2>
            </div>

            {{-- Search --}}
            <div class="p-3 bg-white border-b">
                <input wire:model.live.debounce.300ms="search"
                       class="w-full px-4 py-2 rounded-xl bg-slate-100
                              text-sm focus:outline-none"
                       placeholder="Cari user...">
            </div>

            {{-- ================= CHAT LIST ================= --}}
            <div class="flex-1 overflow-y-auto divide-y">
                @php
                    $conversationData = $this->conversations
                        ->map(function ($user) {
                            $lastMsg = \App\Models\Message::where(function ($q) use ($user) {
                                    $q->where('sender_id', auth()->id())
                                      ->where('user_id', $user->id);
                                })
                                ->orWhere(function ($q) use ($user) {
                                    $q->where('sender_id', $user->id)
                                      ->where('user_id', auth()->id());
                                })
                                ->latest()
                                ->first();

                            return [
                                'user'     => $user,
                                'lastMsg'  => $lastMsg,
                                'lastTime' => $lastMsg?->created_at ?? now()->subYears(10),
                            ];
                        })
                        ->sortByDesc('lastTime')
                        ->values();
                @endphp

                @foreach($conversationData as $row)
                    @php
                        $user = $row['user'];
                        $lastMsg = $row['lastMsg'];
                        $unread = $user->unread_count;
                        $isActive = $selectedUserId === $user->id;
                    @endphp

                    <button wire:click="selectUser({{ $user->id }})"
                        class="w-full px-4 py-3 flex gap-3 items-center transition
                        {{ $isActive ? 'bg-slate-100' : 'hover:bg-slate-50' }}
                        {{ $unread && !$isActive ? 'border-l-4 border-[#fd2800]' : '' }}">

                        {{-- Avatar --}}
                        <div class="w-12 h-12 rounded-full flex items-center justify-center
                                    font-bold text-white
                                    {{ $unread && !$isActive ? 'bg-[#fd2800]' : 'bg-slate-700' }}">
                            {{ strtoupper(substr($user->username, 0, 2)) }}
                        </div>

                        {{-- Text --}}
                        <div class="flex-1 min-w-0 text-left">
                            <div class="flex justify-between items-center">
                                <p class="truncate
                                    {{ $unread && !$isActive
                                        ? 'font-black text-slate-900'
                                        : 'font-semibold text-slate-700'
                                    }}">
                                    {{ $user->username }}
                                </p>

                                <span class="text-[10px]
                                    {{ $unread && !$isActive
                                        ? 'text-[#fd2800] font-bold'
                                        : 'text-slate-400'
                                    }}">
                                    <span class="chat-time"
                                          data-time="{{ $lastMsg?->created_at?->toIso8601String() }}">
                                    </span>
                                </span>
                            </div>

                            <p class="text-sm truncate
                                {{ $unread && !$isActive
                                    ? 'font-bold text-slate-900'
                                    : 'text-slate-500'
                                }}">
                                @if($lastMsg && $lastMsg->sender_id === auth()->id())
                                    <span class="italic text-slate-400">Anda: </span>
                                @endif
                                {{ $lastMsg->message ?? 'Mulai percakapan...' }}
                            </p>
                        </div>

                        {{-- Badge --}}
                        @if($unread && !$isActive)
                            <span class="min-w-[24px] h-6 px-2 rounded-full bg-[#fd2800]
                                         text-white text-xs font-black flex items-center justify-center">
                                {{ $unread }}
                            </span>
                        @endif
                    </button>
                @endforeach
            </div>
        </aside>

        {{-- ================= CHAT AREA ================= --}}
        <main
            class="flex-1 flex flex-col bg-slate-100
                   {{ !$selectedUserId ? 'hidden md:flex' : 'flex' }}"
        >
            @if($selectedUserId)

                @php
                    $activeUser = $this->conversations->firstWhere('id', $selectedUserId);
                @endphp

                {{-- Header --}}
                <div class="h-16 px-4 flex items-center gap-3
                            bg-white border-b sticky top-0 z-20">
                    <button wire:click="$set('selectedUserId', null)"
                        class="md:hidden text-xl font-bold">←</button>

                    <div class="w-10 h-10 rounded-full bg-slate-700
                                text-white flex items-center justify-center font-bold">
                        {{ strtoupper(substr($activeUser->username ?? '', 0, 2)) }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="font-semibold truncate">
                            {{ $activeUser->username ?? '' }}
                        </p>
                        <p class="text-xs text-slate-500">aktif</p>
                    </div>
                </div>
               {{-- Chat Box --}}
                <div id="chat-box"
                     class="flex-1 p-4 space-y-3 overflow-y-auto">
                    @foreach($this->messages->sortBy('created_at')->values() as $msg)
                        @php $me = $msg->sender_id === auth()->id(); @endphp
                        <div class="flex {{ $me ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[75%]">
                                <div class="px-4 py-2 rounded-2xl shadow
                                    {{ $me ? 'bg-[#fd2800] text-white' : 'bg-white border' }}">
                                    {{ $msg->message }}
                                </div>
                                <div class="text-[10px] text-slate-400 mt-1 {{ $me ? 'text-right' : '' }}">
                                    <span class="chat-time"
                                          data-time="{{ $msg->created_at->toIso8601String() }}">
                                    </span>
                                    @if($me)
                                        <span class="{{ $msg->is_read ? 'text-blue-500 font-bold' : '' }}">
                                            {{ $msg->is_read ? '✓✓' : '✓' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Input --}}
                <form wire:submit.prevent="sendMessage"
                      class="h-16 px-3 flex items-center gap-3
                             bg-white border-t sticky bottom-0">
                    <input wire:model.defer="messageText"
                           class="flex-1 h-11 px-4 rounded-full bg-slate-100
                                  text-sm focus:outline-none"
                           placeholder="Ketik pesan...">
                    <button class="w-11 h-11 rounded-full bg-[#fd2800]
                                   text-white flex items-center justify-center">
                        ➤
                    </button>
                </form>

            @else
                <div class="flex-1 flex items-center justify-center text-slate-400">
                    Pilih percakapan
                </div>
            @endif
        </main>
    </div>
</div>

{{-- AUTO SCROLL --}}
<script>
window.addEventListener('chat-scrolled', () => {
    const box = document.getElementById('chat-box');
    if (box) setTimeout(() => box.scrollTop = box.scrollHeight, 50);
});
</script>

{{-- TIMEZONE DEVICE --}}
<script>
function convertChatTime() {
    document.querySelectorAll('.chat-time').forEach(el => {
        const utc = el.dataset.time;
        if (!utc) return;

        const local = new Date(utc);
        el.textContent = local.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
    });
}

/* Saat pertama load */
document.addEventListener('DOMContentLoaded', convertChatTime);

/* 🔥 SETIAP LIVEWIRE SELESAI RENDER */
document.addEventListener('livewire:load', () => {
    Livewire.hook('message.processed', () => {
        convertChatTime();
    });
});

/* Backup manual trigger */
window.addEventListener('chat-scrolled', convertChatTime);
</script>

