<x-app-layout>
    <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }" class="min-h-screen bg-white font-sans text-[#444444]">
        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- 1. HERO SECTION --}}
                <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-[#171717] tracking-tight">Halo, Admin Telah tibaaa !!!!</h1>
                        <p class="mt-2 text-[#444444]">Selamat datang kembali yang mulia. Berikut ringkasan performa sistem hari ini.</p>
                    </div>
                    <div class="flex items-center gap-3">
                         <div class="hidden md:block text-right">
                            <p class="text-sm font-semibold text-[#171717]">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</p>
                            <p class="text-xs text-[#444444]">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
                         </div>
                         <div class="p-3 bg-white rounded-xl shadow-sm border border-[#ededed]">
                            <svg class="w-6 h-6 text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                         </div>
                    </div>
                </div>

                {{-- 2. STATISTICS CARDS --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-10">
                    
                    {{-- Card 1 --}}
                    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-[#ededed] relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-20 h-20 text-[#fd2800]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-[#444444] uppercase tracking-wider">Total Pegawai</p>
                            <p class="text-3xl font-extrabold text-[#171717] mt-2">{{ \App\Models\Pegawai::count() }}</p>
                            <div class="flex items-center mt-4 text-sm">
                                <span class="text-[#fd2800] bg-red-50 px-2 py-0.5 rounded-full font-medium flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                    Data Terkini
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-[#ededed] relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-20 h-20 text-[#171717]" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-[#444444] uppercase tracking-wider">Pegawai Aktif</p>
                            <p class="text-3xl font-extrabold text-[#171717] mt-2">{{ \App\Models\Pegawai::where('status_pegawai', 'aktif')->count() }}</p>
                            <div class="flex items-center mt-4 text-sm">
                                <span class="text-[#444444]">Orang siap bertugas</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-[#ededed] relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                             <svg class="w-20 h-20 text-[#444444]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-[#444444] uppercase tracking-wider">Akun Terdaftar</p>
                            <p class="text-3xl font-extrabold text-[#171717] mt-2">{{ \App\Models\User::where('role', 'user')->count() }}</p>
                             <div class="flex items-center mt-4 text-sm">
                                <span class="text-[#171717] bg-[#ededed] px-2 py-0.5 rounded-full font-medium">User Access</span>
                            </div>
                        </div>
                    </div>

                    {{-- Add Button Card --}}
                    <button @click="showModal = true" class="bg-[#fd2800] hover:bg-[#171717] rounded-2xl p-6 shadow-lg transform transition duration-300 hover:-translate-y-1 hover:shadow-xl text-left relative overflow-hidden group">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div>
                                <div class="bg-white/20 w-10 h-10 rounded-lg flex items-center justify-center mb-3 text-white">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                </div>
                                <p class="text-white font-semibold text-lg">Tambah Pegawai</p>
                                <p class="text-white/80 text-xs mt-1">Input data baru via Pop-up</p>
                            </div>
                            <div class="flex items-center text-white text-sm font-medium mt-4 group-hover:gap-2 transition-all">
                                Klik untuk mulai <span class="opacity-0 group-hover:opacity-100 transition-opacity">&rarr;</span>
                            </div>
                        </div>
                    </button>
                </div>

                {{-- 3. CONTENT SPLIT --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- LEFT COLUMN: TABLE --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-[#ededed] overflow-hidden">
                            <div class="px-6 py-5 border-b border-[#ededed] flex flex-wrap justify-between items-center bg-[#ededed]/30">
                                <div>
                                    <h3 class="text-lg font-bold text-[#171717]">Pegawai Terbaru</h3>
                                    <p class="text-xs text-[#444444]">5 data terakhir yang ditambahkan ke sistem</p>
                                </div>
                                <a href="{{ route('pegawai.index') }}" class="text-sm font-semibold text-[#fd2800] hover:text-[#171717] transition flex items-center gap-1">
                                    Lihat Semua <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </a>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs text-[#444444] uppercase bg-[#ededed] border-b border-[#ededed]">
                                        <tr>
                                            <th class="px-6 py-4 font-bold">Pegawai</th>
                                            <th class="px-6 py-4 font-bold">Jabatan</th>
                                            <th class="px-6 py-4 font-bold">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#ededed]">
                                        @forelse(\App\Models\Pegawai::latest()->take(5)->get() as $pegawai)
                                        <tr class="hover:bg-[#ededed]/50 transition duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    {{-- Avatar Initials: bg-[#ededed] text-[#fd2800] --}}
                                                    <div class="w-10 h-10 rounded-full bg-[#ededed] flex items-center justify-center text-[#fd2800] font-bold text-xs shrink-0 border border-[#444444]/10">
                                                        {{ substr($pegawai->nama_pegawai, 0, 2) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-[#171717]">{{ $pegawai->nama_pegawai }}</div>
                                                        <div class="text-xs text-[#444444] font-mono">{{ $pegawai->nip_pegawai }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-[#171717]">{{ $pegawai->jabatan }}</div>
                                                <div class="text-xs text-[#444444]">{{ $pegawai->bidang_kerja }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{-- Status Badges tailored to palette --}}
                                                @if($pegawai->status_pegawai == 'aktif')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-[#ededed] text-[#171717] border border-[#171717]/20">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-[#171717]"></span>
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-[#fd2800] border border-[#fd2800]/20">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-[#fd2800]"></span>
                                                        {{ ucfirst($pegawai->status_pegawai) }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-[#444444] italic">Belum ada data pegawai.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: SIDEBAR --}}
                    <div class="lg:col-span-1 space-y-6">
                        
                        {{-- Menu Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-[#ededed] p-6">
                            <h3 class="font-bold text-[#171717] mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                                Menu Cepat
                            </h3>
                            <div class="space-y-3">
                                {{-- Menu Item --}}
                                <a href="{{ route('pegawai.index') }}" class="group flex items-center justify-between w-full px-4 py-3 bg-[#ededed]/30 hover:bg-[#ededed] text-[#444444] hover:text-[#171717] rounded-xl transition border border-transparent hover:border-[#444444]/20">
                                    <span class="flex items-center gap-3 font-medium text-sm">
                                        <span class="p-1.5 bg-white rounded-md shadow-sm group-hover:text-[#fd2800] transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                        </span>
                                        Kelola Database
                                    </span>
                                    <svg class="w-4 h-4 text-[#444444] group-hover:text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </a>

                                <button @click="showModal = true" class="group flex items-center justify-between w-full px-4 py-3 bg-[#ededed]/30 hover:bg-[#ededed] text-[#444444] hover:text-[#171717] rounded-xl transition border border-transparent hover:border-[#444444]/20">
                                    <span class="flex items-center gap-3 font-medium text-sm">
                                        <span class="p-1.5 bg-white rounded-md shadow-sm group-hover:text-[#fd2800] transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </span>
                                        Input Pegawai
                                    </span>
                                    <svg class="w-4 h-4 text-[#444444] group-hover:text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Server Status Card --}}
                        <div class="bg-[#171717] rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                             <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#fd2800] rounded-full blur-3xl opacity-30"></div>
                             
                            <div class="flex items-center justify-between mb-4 relative z-10">
                                <h3 class="font-bold text-sm uppercase tracking-wider text-[#ededed]">System Health</h3>
                                <span class="relative flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#fd2800] opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-[#fd2800]"></span>
                                </span>
                            </div>
                            
                            <div class="space-y-4 relative z-10">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#ededed] flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4" /></svg>
                                        Database
                                    </span>
                                    <span class="font-mono text-[#fd2800]">Connected</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#ededed] flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Last Sync
                                    </span>
                                    <span class="font-mono text-[#444444]">Just now</span>
                                </div>
                                <div class="w-full bg-[#444444]/30 rounded-full h-1.5 mt-2">
                                    <div class="bg-[#fd2800] h-1.5 rounded-full" style="width: 98%"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- 
            ==========================================
            MODAL POPUP FORM
            ==========================================
        --}}
        <div 
            x-show="showModal" 
            style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto" 
            aria-labelledby="modal-title" 
            role="dialog" 
            aria-modal="true"
        >
            <div 
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-[#171717]/80 backdrop-blur-sm transition-opacity" 
                @click="showModal = false"
            ></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                
                {{-- Modal Panel --}}
                <div 
                    x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#ededed]"
                >
                    
                    {{-- Header --}}
                    <div class="bg-white px-6 py-5 border-b border-[#ededed] flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-[#171717]" id="modal-title">Tambah Pegawai Baru</h3>
                            <p class="text-sm text-[#444444] mt-1">Lengkapi form di bawah ini untuk input data.</p>
                        </div>
                        <button @click="showModal = false" class="text-[#444444] hover:text-[#171717] bg-[#ededed] hover:bg-[#ededed]/80 p-2 rounded-full transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Form Body --}}
                    <form action="{{ route('pegawai.store') }}" method="POST">
                        @csrf
                        <div class="px-6 py-6 space-y-5">
                            
                            {{-- Input: User --}}
                            <div class="space-y-1">
                                <label class="block text-sm font-semibold text-[#171717]">Tautkan Akun User <span class="text-[#fd2800]">*</span></label>
                                <div class="relative">
                                    {{-- Focus ring uses #fd2800 --}}
                                    <select name="id_pengguna" class="block w-full rounded-lg border-[#ededed] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 pl-3 pr-10 text-[#171717]">
                                        <option value="">-- Pilih User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('id_pengguna') == $user->id ? 'selected' : '' }}>
                                                {{ $user->username }} (ID: {{ $user->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_pengguna') <p class="text-[#fd2800] text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Grid: NIP & Nama --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-[#171717]">NIP <span class="text-[#fd2800]">*</span></label>
                                    <input type="text" name="nip_pegawai" value="{{ old('nip_pegawai') }}" class="block w-full rounded-lg border-[#ededed] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 text-[#171717]" placeholder="Nomor Induk">
                                    @error('nip_pegawai') <p class="text-[#fd2800] text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-[#171717]">Nama Lengkap <span class="text-[#fd2800]">*</span></label>
                                    <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" class="block w-full rounded-lg border-[#ededed] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 text-[#171717]" placeholder="Nama Pegawai">
                                    @error('nama_pegawai') <p class="text-[#fd2800] text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Grid: Jabatan & Bidang --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-[#171717]">Jabatan</label>
                                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="block w-full rounded-lg border-[#ededed] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 text-[#171717]">
                                    @error('jabatan') <p class="text-[#fd2800] text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-[#171717]">Bidang Kerja</label>
                                    <input type="text" name="bidang_kerja" value="{{ old('bidang_kerja') }}" class="block w-full rounded-lg border-[#ededed] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 text-[#171717]">
                                    @error('bidang_kerja') <p class="text-[#fd2800] text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <input type="hidden" name="status_pegawai" value="aktif">
                        </div>

                        {{-- Footer Actions --}}
                        <div class="bg-[#ededed]/30 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-2xl border-t border-[#ededed]">
                            {{-- Button Submit: #fd2800 --}}
                            <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-[#fd2800] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#fd2800]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#fd2800] transition sm:w-auto">
                                Simpan Data
                            </button>
                            {{-- Button Batal --}}
                            <button @click="showModal = false" type="button" class="inline-flex w-full justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#171717] shadow-sm ring-1 ring-inset ring-[#ededed] hover:bg-[#ededed] sm:w-auto transition">
                                Batal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>