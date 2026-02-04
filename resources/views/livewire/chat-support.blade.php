{{-- ========================================================= --}}
{{-- CHAT SUPPORT – PROFESSIONAL RESPONSIVE UI --}}
{{-- ========================================================= --}}

<div class="fixed inset-x-3 md:inset-x-6 top-16 md:top-20 bottom-4 z-40">
    <div class="flex flex-col h-full bg-white
                border border-slate-200
                rounded-2xl shadow-xl overflow-hidden">

        {{-- ================= HEADER ================= --}}
        <div class="shrink-0 px-5 md:px-6 py-4
                    bg-white border-b border-slate-100">

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl
                                bg-[#fd2800]/10
                                flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6 text-[#fd2800]"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7 8h10M7 12h6m-6 4h8" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-[15px] font-semibold text-slate-800">
                            Support Center
                        </h2>
                        <p class="text-[11px] text-slate-500 font-medium">
                            Layanan bantuan resmi
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[11px] font-semibold text-emerald-600 uppercase">
                        Online
                    </span>
                </div>
            </div>
        </div>

        {{-- POLLING --}}
        <div wire:poll.2s class="hidden"></div>

        {{-- ================= CHAT BODY ================= --}}
        <div id="chat-container"
             class="flex-1 overflow-y-auto
                    px-4 md:px-6 py-6
                    space-y-6 bg-slate-50">

            {{-- Info --}}
            <div class="flex justify-center">
                <div class="px-4 py-2 rounded-lg
                            bg-slate-100 border border-slate-200">
                    <p class="text-[10px] text-slate-500 font-semibold tracking-wide uppercase">
                        Percakapan bersifat pribadi dan aman
                    </p>
                </div>
            </div>

            @foreach($messages as $msg)
                @php $isMe = $msg->sender_id === auth()->id(); @endphp

                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[90%] sm:max-w-[75%] md:max-w-[65%]
                                flex flex-col
                                {{ $isMe ? 'items-end' : 'items-start' }}">

                        <div class="px-4 py-3 rounded-xl text-sm leading-relaxed
                            {{ $isMe
                                ? 'bg-[#fd2800] text-white rounded-br-none'
                                : 'bg-white border border-slate-200 text-slate-800 rounded-bl-none' }}">
                            {{ $msg->message }}
                        </div>

                        <span class="mt-1.5 text-[10px] text-slate-400 font-medium">
                            {{ $msg->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ================= INPUT ================= --}}
        <div class="shrink-0 px-4 md:px-6 py-4
                    bg-white border-t border-slate-100">

            <form wire:submit.prevent="sendMessage"
                  class="flex items-center gap-3">

                <input wire:model.defer="messageText"
                       type="text"
                       placeholder="Tulis pesan..."
                       class="flex-1 h-12 px-5 rounded-xl
                              bg-slate-50 border border-slate-200
                              text-slate-800 text-sm
                              focus:ring-4 focus:ring-[#fd2800]/10
                              focus:border-[#fd2800]/30
                              outline-none transition">

                <button
                    class="h-12 w-12 rounded-xl
                           bg-[#fd2800] text-white
                           flex items-center justify-center
                           hover:bg-[#e02400]
                           active:scale-95 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 12h14M13 5l7 7-7 7" />
                    </svg>
                </button>
            </form>

            <p class="mt-2 text-center text-[10px]
                      text-slate-400 font-medium">
                Tekan Enter untuk mengirim pesan
            </p>
        </div>
    </div>
</div>


<script>
document.addEventListener('livewire:initialized', () => {
    const container = document.getElementById('chat-container');

    const scrollBottom = (behavior = 'smooth') => {
        if (container) {
            container.scrollTo({
                top: container.scrollHeight,
                behavior: behavior
            });
        }
    };

    const isUserAtBottom = () => {
        const threshold = 150;
        return container.scrollTop + container.clientHeight >= container.scrollHeight - threshold;
    };

    // 1. Initial Scroll saat chat dibuka
    setTimeout(() => {
        scrollBottom('auto');
    }, 150);

    // 2. Saat pesan baru masuk (Polling)
    Livewire.on('messages-updated', () => {
        requestAnimationFrame(() => {
            if (isUserAtBottom()) {
                scrollBottom('smooth');
            }
        });
    });

    // 3. Saat user mengirim pesan sendiri
    Livewire.on('chat-sent', () => {
        requestAnimationFrame(() => {
            scrollBottom('smooth');
        });
    });
});
</script>