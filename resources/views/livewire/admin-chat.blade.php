<div> {{-- SATU-SATUNYA ROOT ELEMENT --}}
    <div class="fixed inset-x-0 bottom-0 top-16 md:top-20 md:inset-x-6 md:bottom-6 z-10">
        <div class="flex h-full bg-white rounded-none md:rounded-3xl shadow-2xl overflow-hidden border border-slate-200">

            {{-- ================= SIDEBAR ================= --}}
            <aside class="bg-white border-r border-slate-100 w-full md:w-[380px] flex flex-col transition-all duration-300 {{ $selectedUserId ? 'hidden md:flex' : 'flex' }}">

                <div class="h-20 px-6 flex items-center justify-between bg-white border-b border-slate-50">
                    <h2 class="font-black text-2xl text-[#171717] tracking-tight">Messages</h2>
                </div>

                <div class="p-4 bg-white border-b border-slate-50">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input wire:model.debounce.500ms="search"
                               class="w-full pl-11 pr-4 py-3 rounded-2xl bg-[#ededed] text-sm focus:bg-white focus:ring-2 focus:ring-[#fd2800] focus:outline-none transition-all border-none"
                               placeholder="Cari user...">
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto custom-scrollbar" wire:poll.5s>
                    {{-- DEFINISI VARIABLE AGAR TIDAK ERROR UNDEFINED --}}
                    @php
                        static $conversationCache = null;
                        if ($conversationCache === null) {
                            $conversationCache = $this->conversations->map(function ($user) {
                                $lastMsg = \App\Models\Message::where(function ($q) use ($user) {
                                        $q->where('sender_id', auth()->id())->where('user_id', $user->id);
                                    })
                                    ->orWhere(function ($q) use ($user) {
                                        $q->where('sender_id', $user->id)->where('user_id', auth()->id());
                                    })
                                    ->latest()->first();

                                return [
                                    'user'     => $user,
                                    'lastMsg'  => $lastMsg,
                                    'lastTime' => $lastMsg?->created_at ?? now()->subYears(10),
                                ];
                            })->sortByDesc('lastTime')->values();
                        }
                        $conversationData = $conversationCache;
                    @endphp

                    @foreach($conversationData as $row)
                        @php
                            $user = $row['user'];
                            $lastMsg = $row['lastMsg'];
                            $unread = $user->unread_count;
                            $isActive = $selectedUserId === $user->id;
                        @endphp

                        <button wire:click="selectUser({{ $user->id }})"
                            class="w-full px-5 py-4 flex gap-4 items-center transition-all relative border-b border-slate-50
                            {{ $isActive ? 'bg-[#fd2800]/5' : 'hover:bg-slate-50' }}">
                            
                            @if($isActive)
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#fd2800]"></div>
                            @endif

                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-bold text-white shadow-sm flex-shrink-0
                                {{ $unread && !$isActive ? 'bg-[#fd2800]' : 'bg-[#444444]' }}">
                                {{ strtoupper(substr($user->username ?? '?', 0, 2)) }}
                            </div>

                            <div class="flex-1 min-w-0 text-left">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <h3 class="truncate text-[15px] {{ $unread && !$isActive ? 'font-black text-[#171717]' : 'font-bold text-[#444444]' }}">
                                        {{ $user->username }}
                                    </h3>
                                    <span class="text-[11px] font-medium text-slate-400">
                                        {{ $lastMsg?->created_at?->timezone('Asia/Jakarta')->format('H:i') }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm truncate {{ $unread && !$isActive ? 'text-[#171717] font-bold' : 'text-slate-500' }}">
                                        @if($lastMsg && $lastMsg->sender_id === auth()->id())
                                            <span class="text-[#fd2800] font-medium">Anda: </span>
                                        @endif
                                        {{ $lastMsg->message ?? 'Mulai percakapan...' }}
                                    </p>
                                    @if($unread && !$isActive)
                                        <span class="ml-2 min-w-[20px] h-5 px-1.5 rounded-full bg-[#fd2800] text-white text-[10px] font-black flex items-center justify-center">
                                            {{ $unread }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </aside>

            {{-- ================= CHAT AREA ================= --}}
            <main class="flex-1 flex flex-col bg-[#ededed]/40 {{ !$selectedUserId ? 'hidden md:flex' : 'flex' }}">
                @if($selectedUserId)
                    @php $activeUser = \App\Models\User::find($selectedUserId); @endphp
                    
                    <div class="h-20 px-6 flex items-center justify-between bg-white border-b border-slate-100 shadow-sm">
                        <div class="flex items-center gap-4">
                            <button wire:click="$set('selectedUserId', null)" class="md:hidden p-2 -ml-2 hover:bg-slate-100 rounded-full">
                                <svg class="w-6 h-6 text-[#171717]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <div class="w-11 h-11 rounded-xl bg-[#444444] text-white flex items-center justify-center font-bold shadow-inner">
                                {{ strtoupper(substr($activeUser->username ?? '?', 0, 2)) }}
                            </div>
                            <div>
                                <h2 class="font-bold text-[#171717] leading-tight">{{ $activeUser->username }}</h2>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                    <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Online</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="chat-box" class="flex-1 p-6 space-y-6 overflow-y-auto custom-scrollbar" wire:poll.2s>
                        @foreach($this->messages as $msg)
                            @php $me = $msg->sender_id === auth()->id(); @endphp
                            <div class="flex {{ $me ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[85%] md:max-w-[70%]">
                                    <div class="px-5 py-3 shadow-sm text-[15px] leading-relaxed
                                        {{ $me ? 'bg-[#fd2800] text-white rounded-2xl rounded-tr-none' : 'bg-white text-[#444444] rounded-2xl rounded-tl-none border border-slate-100' }}">
                                        {{ $msg->message }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-1.5 {{ $me ? 'justify-end' : 'justify-start' }}">
                                        <span class="text-[10px] font-bold text-slate-400 chat-time" data-time="{{ $msg->created_at->toIso8601String() }}">
                                            {{ $msg->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 bg-white border-t border-slate-100">
                        <form wire:submit.prevent="sendMessage" class="flex items-center gap-3">
                            <input wire:model.defer="messageText"
                                   class="flex-1 h-12 px-6 rounded-2xl bg-[#ededed] text-[15px] border-none focus:ring-2 focus:ring-[#fd2800]/30 transition-all shadow-inner"
                                   placeholder="Tulis pesan anda...">
                            <button type="submit"
                                    class="w-12 h-12 rounded-2xl bg-[#fd2800] text-white flex items-center justify-center shadow-lg shadow-[#fd2800]/30 hover:brightness-110 active:scale-95 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center bg-white p-12 text-center">
                        <div class="w-24 h-24 bg-[#ededed] rounded-3xl flex items-center justify-center mb-6 rotate-12 shadow-sm">
                            <svg class="w-12 h-12 text-[#fd2800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-[#171717] mb-2 tracking-tight">Belum ada obrolan terpilih</h2>
                        <p class="text-sm text-slate-500 max-w-[240px] leading-relaxed">Pilih user dari daftar pesan untuk mulai berkomunikasi.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>

    <script>
    document.addEventListener('livewire:initialized', () => {
        const convertChatTime = () => {
            document.querySelectorAll('.chat-time').forEach(el => {
                const utc = el.dataset.time;
                if (!utc) return;
                const d = new Date(utc);
                if (!isNaN(d)) {
                    el.textContent = d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
                }
            });
        };

        const scrollToBottom = () => {
            const box = document.getElementById('chat-box');
            if (box) box.scrollTop = box.scrollHeight;
        };

        convertChatTime();
        scrollToBottom();

        window.addEventListener('chat-scrolled', () => {
            requestAnimationFrame(() => {
                scrollToBottom();
                convertChatTime();
            });
        });

        const observeChatBox = () => {
            const box = document.getElementById('chat-box');
            if (!box) return;
            const observer = new MutationObserver(() => {
                scrollToBottom();
                convertChatTime();
            });
            observer.observe(box, { childList: true, subtree: true });
        };

        observeChatBox();
        Livewire.hook('message.processed', () => { observeChatBox(); });
    });
    </script>
</div> {{-- AKHIR ROOT ELEMENT --}}