<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <div class="flex items-center gap-8">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="transition transform hover:scale-105">
                        <x-application-logo class="block h-9 w-auto fill-current text-blue-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:flex">
                    
                    @if(Auth::user()->role === 'admin')
                        {{-- 1. DASHBOARD ADMIN --}}
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        {{-- 2. MANAJEMEN PEGAWAI --}}
                        <x-nav-link :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Pegawai') }}
                        </x-nav-link>

                        {{-- 3. MANAJEMEN ASET --}}
                        <x-nav-link :href="route('admin.aset.index')" :active="request()->routeIs('admin.aset.*')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Data Aset') }}
                        </x-nav-link>

                        {{-- [BARU] 4. PERMINTAAN PEMINJAMAN --}}
                        <x-nav-link :href="route('admin.peminjaman.index')" :active="request()->routeIs('admin.peminjaman.*')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Permintaan Masuk') }}
                            {{-- Opsional: Badge Notification jika ada data pending --}}
                            @php
                                $pendingCount = \App\Models\Peminjaman::where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span id="pending-badge" class="ml-2 inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </x-nav-link>

                    @else
                        {{-- MENU USER BIASA --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        
                        {{-- Menu Riwayat User (Opsional, jika route user history ada) --}}
                         <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Riwayat Saya') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 pl-3 pr-2 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 bg-gray-50 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 ring-1 ring-gray-200">
                            <div class="text-right hidden md:block">
                                <div class="text-gray-700 font-bold">{{ Auth::user()->username }}</div>
                                <div class="text-xs text-gray-400 font-normal uppercase tracking-wider">{{ Auth::user()->role ?? 'User' }}</div>
                            </div>
                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-sm">
                                {{ substr(Auth::user()->username, 0, 1) }}
                            </div>
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="flex items-center gap-2 text-red-600"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')">
                    {{ __('Pegawai') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.aset.index')" :active="request()->routeIs('admin.aset.*')">
                    {{ __('Data Aset') }}
                </x-responsive-nav-link>

                {{-- [BARU] Link Mobile untuk Approval --}}
                <x-responsive-nav-link :href="route('admin.peminjaman.index')" :active="request()->routeIs('admin.peminjaman.*')">
                    {{ __('Permintaan Masuk') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index')">
                    {{ __('Riwayat Saya') }}
                </x-responsive-nav-link>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
                    {{ substr(Auth::user()->username, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->username }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-red-600"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>