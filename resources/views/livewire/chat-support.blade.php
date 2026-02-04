{{-- ========================================================= --}}
{{-- CHAT BANTUAN USER – FINAL (STABIL & FIX TIMEZONE) --}}
{{-- ========================================================= --}}

<div
    style="position:fixed;top:5rem;left:1rem;right:1rem;bottom:1rem;z-index:40;"
>
    <div class="flex flex-col h-full bg-slate-900
                border border-slate-700
                rounded-2xl shadow-2xl overflow-hidden">

        {{-- ================= HEADER ================= --}}
        <div class="shrink-0 px-6 py-4 bg-slate-800
                    border-b border-slate-700
                    flex justify-between items-center">

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#fd2800]/20
                            flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#fd2800]" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 3"/>
                    </svg>
                </div>

                <div>
                    <h3 class="font-semibold text-slate-100">Chat Bantuan</h3>
                    <p class="text-xs text-slate-400">Terhubung dengan Admin</p>
                </div>
            </div>

            <span class="flex items-center gap-1.5
                         bg-[#fd2800]/15 text-[#fd2800]
                         px-3 py-1 rounded-full text-[10px] font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-[#fd2800] animate-pulse"></span>
                ONLINE
            </span>
        </div>

        {{-- 🔥 POLLING TERISOLASI (WAJIB) --}}
        <div wire:poll.2s class="hidden"></div>

        {{-- ================= CHAT BODY ================= --}}
        <div id="chat-container"
             class="flex-1 min-h-0 overflow-y-auto
                    p-4 md:p-6 space-y-5
                    bg-slate-900 scroll-smooth">

            @forelse($this->messages as $msg)
                @php $isMe = $msg->sender_id === auth()->id(); @endphp

                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[80%] md:max-w-[60%]
                                flex flex-col
                                {{ $isMe ? 'items-end' : 'items-start' }}">

                        <span class="text-[10px] text-slate-400 mb-1 px-1">
                            {{ $isMe ? 'Anda' : 'Admin' }}
                        </span>

                        <div class="px-4 py-2.5 rounded-2xl shadow
                            {{ $isMe
                                ? 'bg-[#fd2800] text-white rounded-br-none'
                                : 'bg-slate-800 text-slate-100 rounded-bl-none' }}">
                            {{ $msg->message }}
                        </div>

                        <span class="text-[9px] text-slate-500 mt-1 chat-time"
                              data-time="{{ $msg->created_at->toIso8601String() }}">
                        </span>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-full
                            text-slate-400 italic text-sm">
                    Belum ada pesan
                </div>
            @endforelse
        </div>

        {{-- ================= INPUT ================= --}}
        <div class="shrink-0 px-4 py-3 bg-slate-800 border-t border-slate-700">
            <form wire:submit.prevent="sendMessage"
                  class="flex items-center gap-3">

                <input wire:model.defer="messageText"
                       type="text"
                       placeholder="Tulis pesan..."
                       class="flex-1 h-11 px-4 rounded-full
                              bg-slate-900 text-slate-100 text-sm
                              ring-1 ring-slate-600
                              focus:ring-2 focus:ring-[#fd2800]
                              outline-none">

                <button type="submit"
                        class="h-11 w-11 rounded-full bg-[#fd2800]
                               hover:bg-[#e02400]
                               text-white flex items-center justify-center">
                    ➤
                </button>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('livewire:load', () => {
    const container = document.getElementById('chat-container');
    if (!container) return;

    let shouldScroll = true;

    const scrollBottom = () => {
        container.scrollTop = container.scrollHeight;
    };

    const convertChatTime = () => {
        document.querySelectorAll('.chat-time').forEach(el => {
            if (!el.dataset.time) return;
            const d = new Date(el.dataset.time);
            el.textContent = d.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        });
    };

    container.addEventListener('scroll', () => {
        shouldScroll =
            container.scrollTop + container.clientHeight
            >= container.scrollHeight - 50;
    });

    Livewire.hook('message.processed', () => {
        convertChatTime();
        if (shouldScroll) scrollBottom();
    });

    // first load
    requestAnimationFrame(() => {
        convertChatTime();
        scrollBottom();
    });
});
</script>
