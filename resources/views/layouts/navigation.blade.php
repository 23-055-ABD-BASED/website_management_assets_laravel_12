@php
    use App\Models\Peminjaman;

    $isAdmin = Auth::user()->role === 'admin';
    $pendingCount = $isAdmin
        ? Peminjaman::where('status', 'pending')->count()
        : 0;
@endphp

<nav x-data="{ open: false }"
     class="sticky top-0 z-50 bg-white border-b border-gray-200">

    {{-- ================= CONTAINER ================= --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- ================= LEFT ================= --}}
            <div class="flex items-center gap-10">

                {{-- LOGO --}}
                <a href="{{ $isAdmin ? route('admin.dashboard') : route('dashboard') }}"
                   class="flex items-center gap-2 font-semibold text-blue-600">
                    <x-application-logo class="h-9 w-auto"/>
                    <span class="hidden sm:block text-gray-800 tracking-wide">
                        Asset System
                    </span>
                </a>

                {{-- DESKTOP MENU --}}
                <div class="hidden sm:flex items-center gap-6 text-sm font-medium text-gray-600">

                    @if($isAdmin)

                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')">
                            Pegawai
                        </x-nav-link>

                        <x-nav-link :href="route('admin.aset.index')" :active="request()->routeIs('admin.aset.*')">
                            Data Aset
                        </x-nav-link>

                        {{-- PERMINTAAN --}}
                        <x-nav-link :href="route('admin.peminjaman.index')" :active="request()->routeIs('admin.peminjaman.*')">
                            Permintaan
                            @if($pendingCount > 0)
                                <span class="ml-2 rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </x-nav-link>

                        {{-- CHAT --}}
                        <x-nav-link :href="route('admin.chat.index')" :active="request()->routeIs('admin.chat.index')" class="relative">
                            Live Chat
                            <span id="chat-dot"
                                  class="hidden absolute -top-1 -right-3 h-2.5 w-2.5 rounded-full bg-red-500 animate-pulse">
                            </span>
                        </x-nav-link>

                    @else

                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index')">
                            Riwayat
                        </x-nav-link>

                        <x-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.index')" class="relative">
                            Chat Bantuan
                            <span id="chat-dot"
                                  class="hidden absolute -top-1 -right-3 h-2.5 w-2.5 rounded-full bg-red-500 animate-pulse">
                            </span>
                        </x-nav-link>

                    @endif
                </div>
            </div>

            {{-- ================= RIGHT ================= --}}
            <div class="hidden sm:flex items-center gap-4">

                {{-- USER INFO --}}
                <div class="flex items-center gap-3 rounded-full bg-gray-50 px-4 py-1.5 ring-1 ring-gray-200">

                    <div class="hidden md:block text-right leading-tight">
                        <div class="text-sm font-semibold text-gray-700">
                            {{ Auth::user()->username }}
                        </div>
                        <div class="text-[11px] uppercase tracking-wide text-gray-400">
                            {{ Auth::user()->role }}
                        </div>
                    </div>

                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                </div>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-full px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 transition">
                        Logout
                    </button>
                </form>
            </div>

            {{-- ================= MOBILE TOGGLE ================= --}}
            <button @click="open = !open"
                    class="sm:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{ 'hidden': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- ================= MOBILE MENU ================= --}}
    <div x-show="open" x-transition
         class="sm:hidden border-t border-gray-100 bg-white">

        <div class="space-y-1 px-4 py-3 text-sm font-medium text-gray-700">

            @if($isAdmin)

                <x-responsive-nav-link :href="route('admin.dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pegawai.index')">Pegawai</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.aset.index')">Data Aset</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.peminjaman.index')">
                    Permintaan
                    @if($pendingCount > 0)
                        <span class="ml-2 text-xs font-semibold text-red-600">
                            ({{ $pendingCount }})
                        </span>
                    @endif
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.chat.index')" class="relative">
                    Live Chat
                    <span id="chat-dot"
                          class="hidden absolute top-3 right-4 h-2.5 w-2.5 rounded-full bg-red-500 animate-pulse">
                    </span>
                </x-responsive-nav-link>

            @else

                <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('peminjaman.index')">Riwayat</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('chat.index')" class="relative">
                    Chat Bantuan
                    <span id="chat-dot"
                          class="hidden absolute top-3 right-4 h-2.5 w-2.5 rounded-full bg-red-500 animate-pulse">
                    </span>
                </x-responsive-nav-link>

            @endif

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button class="w-full text-left text-red-600 font-semibold">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ================= HIDE CHAT DOT ON CHAT PAGE ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (location.pathname.includes('/chat')) {
        document.querySelectorAll('#chat-dot').forEach(el => el.classList.add('hidden'));
    }
});
</script>
