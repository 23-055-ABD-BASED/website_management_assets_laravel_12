<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <div class="flex items-center gap-8">
                <div class="shrink-0 flex items-center">
                    {{-- LOGIC: Logo mengarah ke dashboard sesuai role --}}
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="transition transform hover:scale-105">
                        <x-application-logo class="block h-9 w-auto fill-current text-blue-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:flex">
                    
                    @if(Auth::user()->role === 'admin')
                        {{-- MENU KHUSUS ADMIN --}}
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Manajemen Pegawai') }}
                        </x-nav-link>

                        {{-- [BARU] MANAJEMEN ASET --}}
                        <x-nav-link :href="route('admin.aset.index')" :active="request()->routeIs('admin.aset.*')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Manajemen Aset') }}
                        </x-nav-link>

                    @else
                        {{-- MENU KHUSUS USER BIASA --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                            class="text-sm font-medium transition-colors duration-200 hover:text-blue-600">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            {{-- Settings Dropdown Desktop --}}
            <div class="hidden sm:flex sm:items-center sm:gap-4">
                
                <button class="relative p-2 text-gray-400 hover:text-gray-500 transition">
                    <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

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
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="flex items-center gap-2 text-red-600 hover:bg-red-50 hover:text-red-700"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            
            @if(Auth::user()->role === 'admin')
                {{-- MOBILE MENU ADMIN --}}
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Admin Dashboard') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('pegawai.index')" :active="request()->routeIs('pegawai.*')">
                    {{ __('Manajemen Pegawai') }}
                </x-responsive-nav-link>

                {{-- [BARU] MANAJEMEN ASET MOBILE --}}
                <x-responsive-nav-link :href="route('admin.aset.index')" :active="request()->routeIs('admin.aset.*')">
                    {{ __('Manajemen Aset') }}
                </x-responsive-nav-link>
            @else
                {{-- MOBILE MENU USER --}}
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif

        </div>

        {{-- Responsive Settings Options --}}
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