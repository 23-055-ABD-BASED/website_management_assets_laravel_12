<x-app-layout>
    <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }" class="min-h-screen bg-gray-50 font-sans text-slate-600">
        
        <div class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                {{-- 1. HERO HEADER SECTION --}}
                <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-[#171717] tracking-tight">Halo, Selamat Datang Kembali Tuan !!!</h1>
                        <p class="mt-2 text-slate-500">Berikut adalah ringkasan performa dan pertumbuhan data bulan ini.</p>
                    </div>

                    {{-- Time Widget --}}
                   <div class="flex items-center gap-3">
                        {{-- 1. BAGIAN JAM (TEXT) --}}
                        {{-- Ubah: order-2 (mobile/tab kanan), lg:order-1 (desktop kiri) --}}
                        {{-- Ubah: items-start (mobile/tab rata kiri), lg:items-end (desktop rata kanan) --}}
                        <div x-data="{
                                time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':'),
                                init() {
                                    setInterval(() => {
                                        this.time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
                                    }, 1000);
                                }
                            }" 
                            class="flex flex-col order-2 lg:order-1 items-start lg:items-end"> 
                            
                            <span class="text-2xl font-bold text-[#171717] font-mono leading-none" x-text="time"></span>
                            <span class="text-xs text-slate-400 font-medium text-left lg:text-right">
                                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                            </span>
                        </div>

                        {{-- 2. BAGIAN ICON --}}
                        {{-- Ubah: order-1 (mobile/tab kiri), lg:order-2 (desktop kanan) --}}
                        <div class="order-1 lg:order-2 p-3 bg-white rounded-xl shadow-sm border border-slate-200">
                            <svg class="w-6 h-6 text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                    </div>
                </div>

                {{-- 2. STATISTICS GRID (UPDATED WITH REALTIME LOGIC) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    
                    {{-- Card 1: Total Pegawai (LOGIC UPDATED) --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-start z-10 relative">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pegawai</p>
                                
                                <div class="flex items-baseline gap-2">
                                    <h3 class="text-3xl font-black text-[#171717] mt-2">{{ $stats['pegawai']['total'] }}</h3>
                                    
                                    @if($stats['pegawai']['diff'] != 0)
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ $stats['pegawai']['is_positive'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $stats['pegawai']['is_positive'] ? '+' : '' }}{{ $stats['pegawai']['percentage'] }}%
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs text-slate-500 font-medium mt-1 flex items-center gap-1">
                                    @if($stats['pegawai']['is_positive'])
                                        <svg class="w-3 h-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                        <span class="text-green-600">+{{ $stats['pegawai']['diff'] }} org</span>
                                    @else
                                        <svg class="w-3 h-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                                        <span class="text-red-600">{{ $stats['pegawai']['diff'] }} org</span>
                                    @endif
                                    <span class="opacity-70">vs bulan lalu</span>
                                </p>
                            </div>
                            <div class="p-3 bg-red-50 rounded-xl text-[#fd2800]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-red-50 rounded-full blur-2xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    {{-- Card 2: User System (MENGGANTIKAN ATAU MENAMBAHKAN STATISTIK USER) --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-start z-10 relative">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total User Akun</p>
                                
                                <div class="flex items-baseline gap-2">
                                    <h3 class="text-3xl font-black text-[#171717] mt-2">{{ $stats['user']['total'] }}</h3>
                                    @if($stats['user']['diff'] != 0)
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ $stats['user']['is_positive'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $stats['user']['is_positive'] ? '+' : '' }}{{ $stats['user']['percentage'] }}%
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs text-blue-600 font-medium mt-1 flex items-center gap-1">
                                    @if($stats['user']['is_positive'])
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                        <span>+{{ $stats['user']['diff'] }} baru</span>
                                    @else
                                        <span>Stabil</span>
                                    @endif
                                </p>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: Total Aset (LOGIC UPDATED) --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-start z-10 relative">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Aset</p>
                                
                                <div class="flex items-baseline gap-2">
                                    <h3 class="text-3xl font-black text-[#171717] mt-2">{{ $stats['aset']['total'] }}</h3>
                                    
                                    @if($stats['aset']['diff'] != 0)
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ $stats['aset']['is_positive'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $stats['aset']['is_positive'] ? '+' : '' }}{{ $stats['aset']['percentage'] }}%
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-xs text-amber-600 font-medium mt-1 flex items-center gap-1">
                                    @if($stats['aset']['is_positive'])
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                        <span>+{{ $stats['aset']['diff'] }} item baru</span>
                                    @elseif($stats['aset']['diff'] < 0)
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                                        <span>{{ $stats['aset']['diff'] }} dihapus</span>
                                    @else
                                        <span>Tidak ada perubahan</span>
                                    @endif
                                </p>
                            </div>
                            <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Card 4: Action Button (Add Pegawai) --}}
                    <button @click="showModal = true" class="group relative rounded-2xl p-6 overflow-hidden text-left shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#171717] to-[#2d2d2d]"></div>
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#fd2800] rounded-full blur-[60px] opacity-20 group-hover:opacity-40 transition-opacity"></div>
                        
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-white">Tambah<br>Pegawai Baru</h3>
                                </div>
                                <div class="bg-white/10 p-2 rounded-lg text-white group-hover:bg-[#fd2800] transition-colors duration-300">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                            </div>
                            <p class="text-xs text-slate-300 mt-4 group-hover:text-white transition-colors">Klik untuk membuka formulir input data.</p>
                        </div>
                    </button>
                </div>

                {{-- 3. CONTENT SPLIT --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
                                <div>
                                    <h3 class="text-lg font-bold text-[#171717]">Pegawai Terbaru</h3>
                                    <p class="text-xs text-slate-400">5 data terakhir yang ditambahkan</p>
                                </div>
                                <a href="{{ route('pegawai.index') }}" class="text-sm font-semibold text-[#fd2800] hover:text-[#171717] transition flex items-center gap-1 group">
                                    Lihat Semua 
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </a>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100">
                                        <tr>
                                            <th class="px-6 py-4 font-bold tracking-wider">Pegawai</th>
                                            <th class="px-6 py-4 font-bold tracking-wider">Jabatan</th>
                                            <th class="px-6 py-4 font-bold tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse($latestPegawai as $pegawai)
                                        <tr class="hover:bg-slate-50 transition duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-full bg-[#171717] flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                                                        {{ substr($pegawai->nama_pegawai, 0, 2) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-[#171717]">{{ $pegawai->nama_pegawai }}</div>
                                                        <div class="text-xs text-slate-400 font-mono tracking-wide">{{ $pegawai->nip_pegawai }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-slate-700 font-medium">{{ $pegawai->jabatan }}</div>
                                                <div class="text-xs text-slate-400">{{ $pegawai->bidang_kerja }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($pegawai->status_pegawai == 'aktif')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600 animate-pulse"></span>
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                                        {{ ucfirst($pegawai->status_pegawai) }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-10 h-10 text-slate-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                                    <p class="italic">Belum ada data pegawai.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                                            <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-red-100 dark:border-red-900/30">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Peminjaman Terlambat</h3>
                <p class="text-sm text-gray-500">Daftar aset yang belum dikembalikan melewati batas waktu</p>
            </div>
        </div>
        <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full border border-red-200">
            {{ $peminjamanTerlambat->count() }} Pelanggaran
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-400 text-xs uppercase tracking-wider border-b dark:border-gray-700">
                    <th class="pb-3 px-4 font-semibold">Pegawai</th>
                    <th class="pb-3 px-4 font-semibold">Aset / Barang</th>
                    <th class="pb-3 px-4 font-semibold">Batas Kembali</th>
                    <th class="pb-3 px-4 font-semibold text-center">Status Keterlambatan</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 dark:text-gray-300">
@forelse($peminjamanTerlambat as $item)
<tr class="border-b dark:border-gray-700 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors text-white">
    {{-- CEK NAMA PEGAWAI --}}
<td class="py-4 px-4 font-medium text-white">
    {{-- Kita panggil kolom nama_pegawai sesuai database kamu --}}
    {{ $item->pegawai->nama_pegawai ?? 'Nama Tidak Terdeteksi' }}
</td>
    
    {{-- CEK NAMA ASET --}}
    <td class="py-4 px-4">
        <div class="flex flex-col">
            {{-- Kita coba panggil 'aset' (indonesia) karena di screenshot controller kamu ada AsetController --}}
            <span class="font-medium text-white">{{ $item->aset->nama_aset ?? $item->asset->nama_aset ?? 'Barang Terhapus' }}</span>
            <span class="text-xs text-gray-400">ID: {{ $item->aset->kode_aset ?? $item->asset->kode_aset ?? '-' }}</span>
        </div>
    </td>

    <td class="py-4 px-4 text-red-500 font-semibold text-center">
        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
    </td>

    {{-- FIX ANGKA DESIMAL PANJANG --}}
    <td class="py-4 px-4 text-center">
        <span class="inline-flex items-center bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">
            Terlambat {{ number_format(\Carbon\Carbon::parse($item->tanggal_kembali)->diffInDays(now()), 0) }} Hari
        </span>
    </td>
</tr>
@empty
...
@endforelse
            </tbody>
        </table>    
    </div>
</div>

                    </div>



{{-- RIGHT COLUMN: SIDEBAR --}}
<div class="lg:col-span-1 space-y-6">
    
    {{-- 1. Navigasi Cepat (Kartu Putih) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="font-bold text-[#171717] mb-5 flex items-center gap-2 text-sm uppercase tracking-wide">
            <span class="w-1 h-5 bg-[#fd2800] rounded-full"></span>
            Navigasi Cepat
        </h3>
        <div class="space-y-3">
            <a href="{{ route('pegawai.index') }}" class="group flex items-center justify-between w-full px-4 py-3 bg-slate-50 hover:bg-[#171717] hover:text-white rounded-xl transition-all duration-200 border border-transparent hover:shadow-md">
                <span class="flex items-center gap-3 font-medium text-sm text-slate-700 group-hover:text-white">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-[#fd2800] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    Kelola Database
                </span>
                <svg class="w-4 h-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

            <button @click="showModal = true" class="group flex items-center justify-between w-full px-4 py-3 bg-slate-50 hover:bg-[#171717] hover:text-white rounded-xl transition-all duration-200 border border-transparent hover:shadow-md">
                <span class="flex items-center gap-3 font-medium text-sm text-slate-700 group-hover:text-white">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-[#fd2800] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Input Pegawai
                </span>
                <svg class="w-4 h-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>
        </div>
    </div>

    {{-- 2. System Status (Kartu Hitam - Berada di Tengah) --}}
    <div class="bg-[#171717] rounded-2xl shadow-xl p-6 text-white relative overflow-hidden ring-1 ring-white/10">
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#fd2800] rounded-full blur-[80px] opacity-20"></div>
        <div class="flex items-center justify-between mb-6 relative z-10">
            <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 flex items-center gap-2">
                <div class="w-2 h-2 bg-[#fd2800] rounded-full animate-pulse"></div>
                System Status
            </h3>
        </div>
        
        <div class="space-y-4 relative z-10 font-mono text-sm">
            <div class="flex justify-between items-center pb-2 border-b border-white/10">
                <span class="text-slate-400">Database</span>
                <span class="text-green-400 font-bold">● ONLINE</span>
            </div>
            <div class="flex justify-between items-center pb-2 border-b border-white/10">
                <span class="text-slate-400">Total Assets</span>
                <span class="text-white font-bold">{{ $stats['aset']['total'] }} Item</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-400 italic">Server Load</span>
                <div class="w-20 bg-white/10 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-[#fd2800] h-full rounded-full animate-pulse" style="width: 42%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Asset Inventory (Sekarang Jadi Kartu Putih di Paling Bawah) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="font-bold text-[#171717] mb-6 flex items-center gap-2 text-sm uppercase tracking-wide">
            <span class="w-1 h-5 bg-blue-600 rounded-full"></span>
            Asset Inventory
        </h3>
        <div class="space-y-5">
            @foreach($stokKategori as $kat)
            @php
                $persenTersedia = ($kat->total > 0) ? ($kat->tersedia / $kat->total) * 100 : 0;
                // Skema warna: Merah (Kritis), Oranye (Menipis), Biru (Aman)
                $warnaBar = $persenTersedia < 30 ? 'bg-red-500' : ($persenTersedia < 70 ? 'bg-orange-500' : 'bg-blue-600');
            @endphp
            <div>
                <div class="flex justify-between text-[11px] mb-1.5">
                    <span class="font-bold text-slate-600 uppercase tracking-tight">{{ $kat->kategori_aset }}</span>
                    <span class="text-slate-400 font-mono">{{ $kat->tersedia }}/{{ $kat->total }}</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden border border-slate-200/50">
                    <div class="{{ $warnaBar }} h-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $persenTersedia }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

        {{-- MODAL POPUP FORM --}}
        <div 
            x-show="showModal" 
            style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto" 
            aria-labelledby="modal-title" 
            role="dialog" 
            aria-modal="true"
        >
            {{-- Overlay Background --}}
            <div 
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-[#171717]/60 backdrop-blur-sm transition-opacity" 
                @click="showModal = false"
            ></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                {{-- BAGIAN INI YANG DIUBAH --}}
                <div 
                    x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all border border-slate-200 
                    w-full max-w-md sm:max-w-lg" 
                >
                {{-- Penjelasan Perubahan Class:
                    1. w-full : Memaksa lebar 100% dari container (agar kotak penuh).
                    2. max-w-md : Membatasi lebar maksimal di HP/Tab agar proporsional (sekitar 448px).
                    3. sm:max-w-lg : Memperlebar batas maksimal saat di layar Laptop (sekitar 512px). 
                --}}
                    
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-[#171717]" id="modal-title">Tambah Pegawai</h3>
                            <p class="text-sm text-slate-500">Lengkapi informasi di bawah ini.</p>
                        </div>
                        <button @click="showModal = false" class="text-slate-400 hover:text-[#fd2800] bg-slate-50 hover:bg-red-50 p-2 rounded-full transition-all">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('pegawai.store') }}" method="POST">
                        @csrf
                        <div class="px-6 py-6 space-y-5">
                            {{-- Input Tautkan Akun --}}
                            <div class="space-y-1.5">
                                <label class="block text-sm font-semibold text-[#171717]">Tautkan Akun User <span class="text-[#fd2800]">*</span></label>
                                <div class="relative">
                                    <select name="id_pengguna" class="block w-full rounded-lg border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 pl-3 pr-10 text-[#171717] bg-slate-50/50">
                                        <option value="">-- Pilih User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('id_pengguna') == $user->id ? 'selected' : '' }}>
                                                {{ $user->username }} (ID: {{ $user->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_pengguna') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Grid NIP & Nama --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-semibold text-[#171717]">NIP <span class="text-[#fd2800]">*</span></label>
                                    <input type="text" name="nip_pegawai" value="{{ old('nip_pegawai') }}" class="block w-full rounded-lg border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50/50 text-[#171717]" placeholder="Contoh: 199001...">
                                    @error('nip_pegawai') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-semibold text-[#171717]">Nama Lengkap <span class="text-[#fd2800]">*</span></label>
                                    <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" class="block w-full rounded-lg border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50/50 text-[#171717]" placeholder="Nama sesuai KTP">
                                    @error('nama_pegawai') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Grid Jabatan & Bidang --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-semibold text-[#171717]">Jabatan</label>
                                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="block w-full rounded-lg border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50/50 text-[#171717]">
                                    @error('jabatan') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-semibold text-[#171717]">Bidang Kerja</label>
                                    <input type="text" name="bidang_kerja" value="{{ old('bidang_kerja') }}" class="block w-full rounded-lg border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50/50 text-[#171717]">
                                    @error('bidang_kerja') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <input type="hidden" name="status_pegawai" value="aktif">
                        </div>

                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-2xl border-t border-slate-100">
                            <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-[#171717] px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-[#fd2800] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#fd2800] transition-colors duration-200 sm:w-auto">
                                Simpan Data
                            </button>
                            <button @click="showModal = false" type="button" class="inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:w-auto transition-colors duration-200">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Script Check: Manual Placement');
        
        @if(isset($peminjamanTerlambat) && $peminjamanTerlambat->count() > 0)
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: 'Peringatan Jatuh Tempo!',
                text: 'Ada {{ $peminjamanTerlambat->count() }} peminjaman yang melewati batas waktu.',
                showConfirmButton: false,
                timer: 8000,
                timerProgressBar: true,
                iconColor: '#fd2800',
                background: '#1c1c1c',
                color: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl border border-white/10 shadow-2xl'
                }
            });
        @endif
    });
</script>