<x-app-layout>
    {{-- Import Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .font-heading { font-family: 'Poppins', sans-serif; }
        .font-body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
        
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>

    <div class="min-h-screen bg-[#f8f9fa] pb-20 pt-8 font-body text-[#444444]" x-data="{ activeTab: 'pending' }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-10 gap-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-[#171717] font-heading">
                        Sirkulasi Aset
                    </h2>
                    <p class="mt-2 text-[#444444] text-base max-w-2xl">
                        Pusat kontrol monitoring pergerakan aset, persetujuan peminjaman, dan riwayat pengembalian.
                    </p>
                </div>

                {{-- Summary Cards --}}
                <div class="flex gap-4">
                    <div class="bg-white p-4 rounded-xl border border-[#ededed] shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex items-center gap-4 min-w-[180px]">
                        <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-[#444444] font-medium uppercase tracking-wider font-heading">Pending</p>
                            <p class="text-2xl font-bold text-[#171717] font-heading">{{ $pending->count() }}</p>
                        </div>
                    </div>

                    <div class="bg-[#171717] p-4 rounded-xl border border-[#171717] shadow-lg flex items-center gap-4 min-w-[180px]">
                        <div class="p-3 bg-[#fd2800] rounded-lg text-white">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider font-heading">Dipinjam</p>
                            <p class="text-2xl font-bold text-white font-heading">{{ $active->count() }} <span class="text-sm font-normal text-gray-500">Unit</span></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Tabs Navigation --}}
            <div class="mb-8 border-b border-[#ededed]">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'pending'" 
                        :class="activeTab === 'pending' ? 'border-[#fd2800] text-[#fd2800]' : 'border-transparent text-[#444444] hover:text-[#171717] hover:border-gray-300'"
                        class="group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium font-heading transition-colors duration-200">
                        <span class="mr-2">Permintaan Baru</span>
                        @if($pending->count() > 0)
                            <span :class="activeTab === 'pending' ? 'bg-[#fd2800] text-white' : 'bg-[#ededed] text-[#444444]'"
                                class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-bold transition-colors">
                                {{ $pending->count() }}
                            </span>
                        @endif
                    </button>

                    <button @click="activeTab = 'active'" 
                        :class="activeTab === 'active' ? 'border-[#fd2800] text-[#fd2800]' : 'border-transparent text-[#444444] hover:text-[#171717] hover:border-gray-300'"
                        class="group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium font-heading transition-colors duration-200">
                        <span class="mr-2">Sedang Dipinjam</span>
                        @if($active->count() > 0)
                            <span :class="activeTab === 'active' ? 'bg-[#fd2800] text-white' : 'bg-[#ededed] text-[#444444]'"
                                class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-bold transition-colors">
                                {{ $active->count() }}
                            </span>
                        @endif
                    </button>

                    <button @click="activeTab = 'history'" 
                        :class="activeTab === 'history' ? 'border-[#fd2800] text-[#fd2800]' : 'border-transparent text-[#444444] hover:text-[#171717] hover:border-gray-300'"
                        class="group inline-flex items-center border-b-2 py-4 px-1 text-sm font-medium font-heading transition-colors duration-200">
                        Riwayat Selesai
                    </button>
                </nav>
            </div>

            {{-- Content Area --}}
            <div class="min-h-[500px] relative">
                
                {{-- TAB 1: PENDING REQUESTS --}}
                <div x-show="activeTab === 'pending'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    @if($pending->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-2xl border border-dashed border-[#ededed]">
                            <div class="bg-green-50 p-4 rounded-full mb-4">
                                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-[#171717] font-heading">Semua Bersih!</h3>
                            <p class="text-sm text-[#444444] mt-1">Tidak ada permintaan peminjaman baru saat ini.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($pending as $item)
                                <div class="group bg-white rounded-2xl p-5 border border-[#ededed] shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:border-[#fd2800]/20 transition-all duration-300 flex flex-col h-full relative overflow-hidden">
                                    
                                    {{-- Decorative Status Line --}}
                                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#fd2800] to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>

                                    {{-- HEADER: User Info --}}
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div class="h-11 w-11 rounded-full bg-[#171717] flex items-center justify-center text-white font-bold text-sm font-heading shadow-md">
                                                    {{ substr($item->pegawai->nama_pegawai, 0, 1) }}
                                                </div>
                                                {{-- Online/Status Indicator --}}
                                                <div class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-[#171717] text-sm font-heading line-clamp-1 leading-tight">{{ $item->pegawai->nama_pegawai }}</h4>
                                                <p class="text-[11px] text-[#888888] font-medium mt-0.5 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    {{ $item->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BODY: Asset Info --}}
                                    <div class="bg-[#f8f9fa] rounded-xl p-4 border border-[#f1f1f1] group-hover:bg-[#fff5f2] group-hover:border-[#ffe0db] transition-colors duration-300">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <p class="text-[10px] font-bold text-[#fd2800] uppercase tracking-wider font-heading mb-1">Peminjaman Aset</p>
                                                <h3 class="text-base font-bold text-[#171717] font-heading leading-tight">{{ $item->aset->nama_aset }}</h3>
                                            </div>
                                            <div class="bg-white p-1.5 rounded-lg shadow-sm border border-[#ededed]">
                                                <svg class="w-5 h-5 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="px-2 py-1 rounded-md bg-white border border-[#ededed] text-[10px] font-mono text-[#444444] font-medium">
                                                {{ $item->aset->kode_aset }}
                                            </span>
                                            <span class="text-[#ededed]">|</span>
                                            <span class="text-xs font-medium text-[#444444] flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->diffInDays($item->tanggal_kembali) + 1 }} Hari
                                            </span>
                                        </div>
                                    </div>

                                    {{-- BODY: Keperluan (New Feature) --}}
                                    <div class="mt-4 mb-auto" x-data="{ open: false }">
                                        <div class="relative pl-3 border-l-2 border-[#ededed] transition-colors duration-300" :class="open ? 'border-[#fd2800]' : ''">
                                            <button @click="open = !open" class="flex items-center justify-between w-full group/btn text-left">
                                                <span class="text-xs font-bold text-[#444444] group-hover/btn:text-[#171717] font-heading flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-[#888888]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                                                    Keperluan / Catatan
                                                </span>
                                                <svg class="w-3 h-3 text-[#888888] transform transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            
                                            <div x-show="open" 
                                                x-collapse 
                                                x-cloak
                                                class="mt-2 text-xs text-[#555555] italic leading-relaxed bg-gray-50 p-2 rounded-lg border border-dashed border-gray-200">
                                                "{{ $item->alasan ?? 'Tidak ada keterangan detail.' }}"
                                            </div>
                                            
                                            {{-- Preview Text (When Closed) --}}
                                            <div x-show="!open" class="mt-1 text-xs text-[#888888] line-clamp-1 cursor-pointer" @click="open = true">
                                                {{ $item->alasan ?? 'Tidak ada keterangan...' }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FOOTER: Actions --}}
                                    <div class="pt-5 mt-4 flex items-center gap-3 border-t border-slate-100">
    {{-- Form Tolak --}}
    <form id="form-reject-{{ $item->id }}" action="{{ route('admin.peminjaman.reject', $item->id) }}" method="POST" class="flex-1">
        @csrf @method('PATCH')
        <button type="button" 
            class="btn-reject-borrow w-full py-2.5 px-4 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-600 hover:bg-red-50 hover:text-[#fd2800] hover:border-red-100 transition-all duration-200 flex items-center justify-center gap-2"
            data-id="{{ $item->id }}"
            data-name="{{ $item->aset->nama_aset }}"
            data-user="{{ $item->pegawai->nama_pegawai }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Tolak
        </button>
    </form>

    {{-- Form Setujui --}}
    <form id="form-approve-{{ $item->id }}" action="{{ route('admin.peminjaman.approve', $item->id) }}" method="POST" class="flex-1">
        @csrf @method('PATCH')
        <button type="button" 
            class="btn-approve-borrow w-full py-2.5 px-4 rounded-xl bg-[#171717] text-xs font-bold text-white hover:bg-[#228B22] shadow-sm hover:shadow-green-500/20 transform active:scale-95 transition-all duration-200 flex items-center justify-center gap-2"
            data-id="{{ $item->id }}"
            data-name="{{ $item->aset->nama_aset }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Setujui
        </button>
    </form>
</div>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- TAB 2: ACTIVE ASSETS --}}
                <div x-show="activeTab === 'active'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    @if($active->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-2xl border border-dashed border-[#ededed]">
                            <div class="bg-[#ededed] p-4 rounded-full mb-4">
                                <svg class="h-8 w-8 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-[#171717] font-heading">Tidak ada aset aktif</h3>
                            <p class="text-sm text-[#444444] mt-1">Saat ini semua aset tersimpan di gudang.</p>
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-sm border border-[#ededed] overflow-hidden">
                            <div class="overflow-x-auto custom-scrollbar">
                                <table class="min-w-full divide-y divide-[#ededed]">
                                    <thead>
                                        <tr class="bg-[#f8f9fa]">
                                            <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Pegawai</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Aset</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Jatuh Tempo</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Status Waktu</th>
                                            <th class="px-6 py-4 text-right text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#ededed]">
                                        @foreach($active as $item)
                                            <tr class="hover:bg-[#f8f9fa] transition-colors group">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="h-9 w-9 flex-shrink-0 rounded-full bg-[#171717] flex items-center justify-center text-white font-bold text-xs">
                                                            {{ substr($item->pegawai->nama_pegawai, 0, 1) }}
                                                        </div>
                                                        <div class="ml-3">
                                                            <div class="text-sm font-bold text-[#171717] font-heading">{{ $item->pegawai->nama_pegawai }}</div>
                                                            <div class="text-xs text-[#444444]">{{ $item->pegawai->nip_pegawai }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex flex-col">
                                                        <span class="text-sm text-[#171717] font-medium">{{ $item->aset->nama_aset }}</span>
                                                        <span class="text-xs text-[#444444] font-mono bg-[#ededed] px-1.5 rounded w-fit mt-1">{{ $item->aset->kode_aset }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-[#444444] font-medium">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</div>
                                                </td>
                                               <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $deadline = \Carbon\Carbon::parse($item->tanggal_kembali)->startOfDay();
                                                        $now = now()->startOfDay();
                                                        $sisaHari = $now->diffInDays($deadline, false);
                                                        $isLate = $sisaHari < 0;
                                                    @endphp

                                                    <div class="flex flex-col gap-1">
                                                        {{-- STATUS DEADLINE --}}
                                                        @if($isLate)
                                                            <div class="flex items-center gap-2 text-[#fd2800]">
                                                                <span class="relative flex h-2.5 w-2.5">
                                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#fd2800]"></span>
                                                                </span>
                                                                <span class="text-xs font-bold font-heading">
                                                                    Telat {{ abs($sisaHari) }} Hari
                                                                </span>
                                                            </div>
                                                        @elseif($sisaHari === 0)
                                                            <span class="inline-flex w-fit items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                                Deadline Hari Ini
                                                            </span>
                                                        @else
                                                            <span class="inline-flex w-fit items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#ededed] text-[#444444]">
                                                                {{ $sisaHari }} Hari Lagi
                                                            </span>
                                                        @endif

                                                        {{-- PENANDA ASET DIGUNAKAN JANGKA PANJANG --}}
                                                        @if($item->digunakan_terlalu_lama)
                                                            <span 
                                                                class="inline-flex w-fit items-center gap-1 px-2 py-0.5 rounded-md bg-red-50 text-red-600 text-[10px] font-bold font-heading"
                                                                title="Aset ini dipinjam dalam durasi jangka panjang"
                                                            >
                                                                Digunakan jangka panjang
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" 
                                                        class="btn-return inline-flex items-center justify-center gap-2 rounded-lg bg-[#171717] px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-[#fd2800] focus:ring-offset-2 transition-all font-heading"
                                                        data-id="{{ $item->id }}"
                                                        data-name="{{ $item->aset->nama_aset }}">
                                                        <span>Kembalikan</span>
                                                    </button>
                                                    <form id="form-return-{{ $item->id }}" action="{{ route('admin.peminjaman.return', $item->id) }}" method="POST" style="display: none;">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="kondisi" id="input-kondisi-{{ $item->id }}">
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- TAB 3: HISTORY --}}
                <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <div class="bg-white rounded-2xl shadow-sm border border-[#ededed] overflow-hidden">
                        <div class="p-6 border-b border-[#ededed] bg-[#f8f9fa] flex flex-col md:flex-row md:items-end justify-between gap-4">
                            <div class="flex gap-4">
                                <div>
                                    <label class="text-xs font-bold text-[#171717] uppercase tracking-wide font-heading block mb-1">Bulan</label>
                                    <select name="bulan" id="bulan" class="block w-full rounded-lg border-[#ededed] bg-white text-sm text-[#444444] focus:border-[#fd2800] focus:ring-[#fd2800] py-2 px-3">
                                        @foreach(range(1,12) as $m)
                                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-[#171717] uppercase tracking-wide font-heading block mb-1">Tahun</label>
                                    <select name="tahun" id="tahun" class="block w-full rounded-lg border-[#ededed] bg-white text-sm text-[#444444] focus:border-[#fd2800] focus:ring-[#fd2800] py-2 pr-8 px-3">
                                        @foreach($tahunList as $tahun)
                                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button onclick="cetakPDF()" class="inline-flex items-center gap-2 rounded-lg bg-[#171717] border border-[#ededed] px-5 py-2.5 text-sm font-bold text-[#EAEFEF] hover:bg-[#fd2800] hover:text-[#EAEFEF] transition-colors font-heading shadow-sm">
                                Cetak Laporan PDF
                            </button>
                        </div>
                        <div class="overflow-x-auto custom-scrollbar">
                            <table class="min-w-full divide-y divide-[#ededed]">
                                <thead>
                                    <tr class="bg-white">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Tanggal Selesai</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Peminjam</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Aset</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Status Akhir</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-[#171717] uppercase tracking-wider font-heading">Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#ededed] bg-white">
                                    @foreach($history as $item)
                                        <tr class="hover:bg-[#f8f9fa] transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#444444]">{{ $item->updated_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-[#171717] font-heading">{{ $item->pegawai->nama_pegawai }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#444444]">{{ $item->aset->nama_aset }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($item->status == 'kembali')
                                                    <span class="inline-flex items-center rounded bg-green-50 px-2 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20 font-heading">Selesai</span>
                                                @else
                                                    <span class="inline-flex items-center rounded bg-red-50 px-2 py-1 text-xs font-bold text-red-700 ring-1 ring-inset ring-red-600/10 font-heading">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#444444]">
                                                @if($item->kondisi_pengembalian)
                                                    <div class="flex items-center gap-2">
                                                        @if($item->kondisi_pengembalian == 'baik')
                                                            <div class="h-2 w-2 rounded-full bg-green-500"></div><span class="text-[#171717] font-medium">Baik</span>
                                                        @else
                                                            <div class="h-2 w-2 rounded-full bg-[#fd2800]"></div><span class="text-[#171717] font-medium capitalize">{{ $item->kondisi_pengembalian }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Toast Notification Setup
            const AsetuToast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#ffffff',
                customClass: { popup: 'rounded-xl shadow-lg border border-slate-100 mt-4' }
            });

            @if(session('success'))
                AsetuToast.fire({ icon: 'success', title: "{{ session('success') }}", iconColor: '#fd2800' });
            @endif

            @if(session('error'))
                Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}", confirmButtonColor: '#fd2800', customClass: { popup: 'rounded-2xl' } });
            @endif

            // 2. Event Delegation for Buttons
            document.body.addEventListener('click', function(e) {
                
                // --- Persetujuan (Approve) ---
                const btnApprove = e.target.closest('.btn-approve-borrow');
                if (btnApprove) {
                    const id = btnApprove.dataset.id;
                    const name = btnApprove.dataset.name;
                    Swal.fire({
                        title: 'Setujui Peminjaman?',
                        html: `Anda akan menyetujui peminjaman aset <br><b>${name}</b>`,
                        icon: 'question',
                        iconColor: '#228B22',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Setujui',
                        confirmButtonColor: '#228B22',
                        cancelButtonColor: '#f1f5f9',
                        reverseButtons: true,
                        buttonsStyling: false,
                        customClass: {
                            popup: 'rounded-2xl shadow-xl border border-slate-100',
                            confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-bold bg-[#228B22] text-white mx-1 hover:bg-green-700',
                            cancelButton: 'rounded-xl px-6 py-2.5 text-sm font-bold bg-slate-100 text-slate-600 mx-1'
                        }
                    }).then((r) => { if (r.isConfirmed) document.getElementById(`form-approve-${id}`).submit(); });
                }

                // --- Penolakan (Reject) ---
                const btnReject = e.target.closest('.btn-reject-borrow');
                if (btnReject) {
                    const id = btnReject.dataset.id;
                    const name = btnReject.dataset.name;
                    const user = btnReject.dataset.user;
                    Swal.fire({
                        title: 'Tolak Peminjaman?',
                        html: `Permohonan <b>${user}</b> untuk aset <br><b>${name}</b> akan ditolak.`,
                        icon: 'warning',
                        iconColor: '#fd2800',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Tolak',
                        confirmButtonColor: '#fd2800',
                        cancelButtonColor: '#f1f5f9',
                        reverseButtons: true,
                        buttonsStyling: false,
                        customClass: {
                            popup: 'rounded-2xl shadow-xl border border-slate-100',
                            confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-bold bg-[#fd2800] text-white mx-1 hover:bg-red-700',
                            cancelButton: 'rounded-xl px-6 py-2.5 text-sm font-bold bg-slate-100 text-slate-600 mx-1'
                        }
                    }).then((r) => { if (r.isConfirmed) document.getElementById(`form-reject-${id}`).submit(); });
                }
                // --- Pengembalian (Return) ---
                const btnReturn = e.target.closest('.btn-return');
                if (btnReturn) {
                    e.preventDefault();
                    const id = btnReturn.dataset.id;
                    const namaAset = btnReturn.dataset.name;

                    Swal.fire({
                        title: '<span class="font-heading text-2xl text-[#171717] font-bold">Verifikasi Pengembalian</span>',
                        html: `
                            <div class="text-left mt-2">
                                <div class="bg-[#f8f9fa] p-4 rounded-xl border border-[#ededed] mb-6">
                                    <p class="text-xs text-[#444444] uppercase tracking-wider font-bold mb-0.5 font-heading">Aset Dikembalikan</p>
                                    <p class="text-[#171717] font-bold text-lg leading-tight font-heading">${namaAset}</p>
                                </div>

                                <p class="text-sm font-bold text-[#171717] mb-3 font-heading">Bagaimana kondisi aset saat ini?</p>

                                <div class="grid grid-cols-1 gap-3" id="swal-radio-group">
                                    <label class="relative flex items-center p-4 rounded-xl border border-[#ededed] cursor-pointer hover:border-[#fd2800] hover:bg-red-50/10 transition-all duration-200 group">
                                        <input type="radio" name="kondisi_fisik" value="baik" class="peer sr-only" checked>
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex flex-col">
                                                <p class="font-bold text-[#171717] text-sm font-heading">Baik / Normal</p>
                                                <p class="text-xs text-[#444444] font-body mt-0.5">Aset berfungsi dengan semestinya</p>
                                            </div>
                                            <div class="w-4 h-4 border-2 border-[#ededed] rounded-full peer-checked:border-[#fd2800] peer-checked:bg-[#fd2800] transition-colors relative"></div>
                                        </div>
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-[#fd2800] pointer-events-none"></div>
                                    </label>

                                    <label class="relative flex items-center p-4 rounded-xl border border-[#ededed] cursor-pointer hover:border-[#fd2800] hover:bg-red-50/10 transition-all duration-200 group">
                                        <input type="radio" name="kondisi_fisik" value="rusak" class="peer sr-only">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex flex-col">
                                                <p class="font-bold text-[#171717] text-sm font-heading">Rusak</p>
                                                <p class="text-xs text-[#444444] font-body mt-0.5">Perlu perbaikan atau servis</p>
                                            </div>
                                            <div class="w-4 h-4 border-2 border-[#ededed] rounded-full peer-checked:border-[#fd2800] peer-checked:bg-[#fd2800] transition-colors relative"></div>
                                        </div>
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-[#fd2800] pointer-events-none"></div>
                                    </label>

                                    <label class="relative flex items-center p-4 rounded-xl border border-[#ededed] cursor-pointer hover:border-[#fd2800] hover:bg-red-50/10 transition-all duration-200 group">
                                        <input type="radio" name="kondisi_fisik" value="hilang" class="peer sr-only">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex flex-col">
                                                <p class="font-bold text-[#171717] text-sm font-heading">Hilang</p>
                                                <p class="text-xs text-[#444444] font-body mt-0.5">Aset tidak ditemukan / hilang</p>
                                            </div>
                                            <div class="w-4 h-4 border-2 border-[#ededed] rounded-full peer-checked:border-[#fd2800] peer-checked:bg-[#fd2800] transition-colors relative"></div>
                                        </div>
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-[#fd2800] pointer-events-none"></div>
                                    </label>
                                </div>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Konfirmasi & Simpan',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        confirmButtonColor: '#fd2800',
                        cancelButtonColor: '#171717',
                        focusConfirm: false,
                        buttonsStyling: true,
                        customClass: {
                            popup: 'rounded-2xl font-body p-0 overflow-hidden',
                            actions: 'bg-[#f8f9fa] w-full m-0 p-4 border-t border-[#ededed] flex justify-end gap-3',
                            confirmButton: 'font-heading font-bold text-sm px-6 py-2.5 rounded-lg shadow-lg shadow-red-500/20 order-2',
                            cancelButton: 'font-heading font-bold text-sm px-6 py-2.5 rounded-lg bg-white text-[#171717] border border-[#ededed] hover:bg-gray-50 order-1 hover:text-black',
                            htmlContainer: '!m-0 !p-6',
                            title: '!p-6 !pb-0 !m-0 flex items-start',
                        },
                        preConfirm: () => {
                            const selectedOption = document.querySelector('input[name="kondisi_fisik"]:checked');
                            if (!selectedOption) {
                                Swal.showValidationMessage('Mohon pilih kondisi aset terlebih dahulu');
                                return false;
                            }
                            return selectedOption.value;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const inputField = document.getElementById('input-kondisi-' + id);
                            const form = document.getElementById('form-return-' + id);

                            if (inputField && form) {
                                inputField.value = result.value;
                                form.submit();
                            }
                        }
                    });
                }
            });
        });

        function cetakPDF() {
            const b = document.getElementById('bulan').value;
            const t = document.getElementById('tahun').value;
            window.open(`/admin/peminjaman/cetak-pdf?bulan=${b}&tahun=${t}`, '_blank');
        }
    </script>
</x-app-layout>