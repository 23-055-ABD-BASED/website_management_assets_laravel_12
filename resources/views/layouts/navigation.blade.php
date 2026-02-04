@php
    use App\Models\Peminjaman;

    $isAdmin = Auth::user()->role === 'admin';
    $pendingCount = $isAdmin
        ? Peminjaman::where('status', 'pending')->count()
        : 0;
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-[#171717] border-b border-[#444444]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            
            <div class="flex items-center gap-8">
                <a href="{{ $isAdmin ? route('admin.dashboard') : route('dashboard') }}" 
                class="flex items-center gap-3">
                    <span class="text-white font-bold tracking-tight text-lg">
                        ASE<span class="text-[#fd2800]">TU</span>
                    </span>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    @php
                        $links = $isAdmin ? [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'active' => 'admin.dashboard'],
                            ['route' => 'pegawai.index', 'label' => 'Pegawai', 'active' => 'pegawai.*'],
                            ['route' => 'admin.aset.index', 'label' => 'Data Aset', 'active' => 'admin.aset.*'],
                            ['route' => 'admin.peminjaman.index', 'label' => 'Permintaan', 'active' => 'admin.peminjaman.*', 'count' => $pendingCount],
                            ['route' => 'admin.chat.index', 'label' => 'Live Chat', 'active' => 'admin.chat.index', 'isChat' => true],
                        ] : [
                            ['route' => 'dashboard', 'label' => 'Dashboard', 'active' => 'dashboard'],
                            ['route' => 'peminjaman.index', 'label' => 'Riwayat', 'active' => 'peminjaman.index'],
                            ['route' => 'chat.index', 'label' => 'Chat Bantuan', 'active' => 'chat.index', 'isChat' => true],
                        ];
                    @endphp

                    @foreach($links as $link)
                        <a href="{{ route($link['route']) }}" 
                           class="relative px-4 py-2 text-sm font-medium transition-colors rounded-md {{ request()->routeIs($link['active']) ? 'text-white' : 'text-gray-400 hover:text-white hover:bg-[#444444]/50' }}">
                            {{ $link['label'] }}
                            @if(isset($link['count']) && $link['count'] > 0)
                                <span class="ml-2 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-[#fd2800] rounded-full">
                                    {{ $link['count'] }}
                                </span>
                            @endif
                            @if(isset($link['isChat']))
                                <span id="chat-dot" class="hidden absolute top-2 right-2 h-2 w-2 rounded-full bg-[#fd2800] animate-pulse"></span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden md:flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-white leading-none mb-1">{{ Auth::user()->username }}</p>
                        <p class="text-[10px] font-bold text-[#fd2800] uppercase tracking-widest">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="h-9 w-9 rounded-full bg-[#444444] border border-gray-600 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button class="px-3 py-2 text-sm font-medium text-gray-400 hover:text-[#fd2800] transition-colors">
                        Logout
                    </button>
                </form>
            </div>

            <button @click="open = true" class="md:hidden p-2 text-gray-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] md:hidden" 
         style="display: none;">
        
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" @click="open = false"></div>

        <div x-show="open" 
             x-transition:enter="transition ease-in-out duration-300 transform" 
             x-transition:enter-start="translate-x-full" 
             x-transition:enter-end="translate-x-0" 
             x-transition:leave="transition ease-in-out duration-300 transform" 
             x-transition:leave-start="translate-x-0" 
             x-transition:leave-end="translate-x-full" 
             class="fixed inset-y-0 right-0 w-[280px] bg-[#444444] shadow-2xl flex flex-col z-[110]">
            
            <div class="flex items-center justify-between px-6 h-16 bg-[#171717] border-b border-[#444444]">
                <span class="text-white font-bold tracking-widest text-sm uppercase">Navigation</span>
                <button @click="open = false" class="text-gray-400 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-lg text-sm font-medium transition-all {{ request()->routeIs($link['active']) ? 'bg-[#fd2800] text-white shadow-lg' : 'text-gray-200 hover:bg-[#171717] hover:text-white' }}">
                        {{ $link['label'] }}
                        @if(isset($link['count']) && $link['count'] > 0)
                            <span class="bg-white text-[#fd2800] px-2 py-0.5 rounded-full text-[10px] font-bold">{{ $link['count'] }}</span>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="p-4 bg-[#171717] border-t border-[#444444]">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="h-10 w-10 rounded-full bg-[#444444] flex items-center justify-center text-white font-bold border border-[#fd2800]">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->username }}</p>
                        <p class="text-[10px] text-[#fd2800] font-bold uppercase tracking-tighter">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button class="w-full py-3 bg-[#fd2800] hover:bg-[#e02400] text-white rounded-lg text-sm font-bold transition-all shadow-md">
                        LOGOUT SYSTEM
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (location.pathname.includes('/chat')) {
        document.querySelectorAll('#chat-dot').forEach(el => el.classList.add('hidden'));
    }
});
</script>