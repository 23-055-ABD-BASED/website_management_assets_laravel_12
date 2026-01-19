<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    <div class="min-h-screen bg-gray-50/50 pb-20 pt-10" x-data="{ activeTab: 'active' }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-6">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                        Manajemen Sirkulasi Aset
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Monitoring pergerakan aset, persetujuan, dan pengembalian dalam satu panel kontrol.
                    </p>
                </div>

                <div class="flex items-center gap-4 bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Aset Dipinjam</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $active->count() }} <span class="text-sm font-normal text-gray-400">Unit</span></p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <nav class="flex space-x-1 bg-gray-100/80 p-1 rounded-xl w-fit" aria-label="Tabs">
                    
                    <button @click="activeTab = 'pending'" 
                        :class="activeTab === 'pending' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                        class="flex items-center rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" :class="activeTab === 'pending' ? 'text-indigo-600' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Permintaan Baru
                        @if($pending->count() > 0)
                            <span class="ml-2 flex h-5 w-5 items-center justify-center rounded-full text-[10px] font-bold ring-1 ring-inset"
                                :class="activeTab === 'pending' ? 'bg-indigo-50 text-indigo-600 ring-indigo-500/20' : 'bg-red-100 text-red-600 ring-red-600/10'">
                                {{ $pending->count() }}
                            </span>
                        @endif
                    </button>

                    <button @click="activeTab = 'active'" 
                        :class="activeTab === 'active' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                        class="flex items-center rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" :class="activeTab === 'active' ? 'text-indigo-600' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Sedang Dipinjam
                        @if($active->count() > 0)
                            <span class="ml-2 flex h-5 w-5 items-center justify-center rounded-full text-[10px] font-bold ring-1 ring-inset"
                                :class="activeTab === 'active' ? 'bg-indigo-50 text-indigo-600 ring-indigo-500/20' : 'bg-gray-200 text-gray-600 ring-gray-500/10'">
                                {{ $active->count() }}
                            </span>
                        @endif
                    </button>

                    <button @click="activeTab = 'history'" 
                        :class="activeTab === 'history' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                        class="flex items-center rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" :class="activeTab === 'history' ? 'text-indigo-600' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Riwayat Selesai
                    </button>
                </nav>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 min-h-[500px] relative">
                
                <div x-show="activeTab === 'pending'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    @if($pending->isEmpty())
                        <div class="flex flex-col items-center justify-center py-24 text-center">
                            <div class="bg-green-50 p-4 rounded-full mb-4">
                                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900">Semua Bersih!</h3>
                            <p class="text-sm text-gray-500 max-w-xs mt-1">Tidak ada permintaan peminjaman baru yang menunggu persetujuan Anda.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 p-6">
                            @foreach($pending as $item)
                                <div class="group relative flex flex-col bg-white border border-gray-200 rounded-xl p-5 hover:border-indigo-300 hover:shadow-lg transition-all duration-300">
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-50 flex items-center justify-center text-indigo-700 font-bold text-sm ring-2 ring-white shadow-sm">
                                            {{ substr($item->pegawai->nama_pegawai, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 text-sm line-clamp-1">{{ $item->pegawai->nama_pegawai }}</h4>
                                            <p class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 rounded-lg p-3 mb-5 border border-gray-100 flex-1">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-0.5 text-gray-400">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $item->aset->nama_aset }}</p>
                                                <p class="text-xs font-mono text-gray-500 mt-0.5">{{ $item->aset->kode_aset }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-200 flex items-center gap-2 text-xs text-gray-600">
                                            <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            <span class="font-medium">
                                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') }} — {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                            </span>
                                            <span class="ml-auto bg-white px-2 py-0.5 rounded border border-gray-200 text-gray-500 font-semibold shadow-sm">
                                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->diffInDays($item->tanggal_kembali) + 1 }} Hari
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 mt-auto">
                                        <form action="{{ route('admin.peminjaman.reject', $item->id) }}" method="POST" class="flex-1">
                                            @csrf @method('PATCH')
                                            <button type="submit" onclick="return confirm('Tolak permintaan ini?')" class="w-full py-2 px-3 bg-white border border-gray-200 rounded-lg text-xs font-semibold text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors">
                                                Tolak
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.peminjaman.approve', $item->id) }}" method="POST" class="flex-1">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="w-full py-2 px-3 bg-indigo-600 rounded-lg text-xs font-semibold text-white hover:bg-indigo-700 shadow-sm transition-all hover:shadow-indigo-200">
                                                Setujui
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div x-show="activeTab === 'active'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    @if($active->isEmpty())
                        <div class="flex flex-col items-center justify-center py-24 text-center">
                            <div class="bg-gray-50 p-4 rounded-full mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900">Tidak ada aset aktif</h3>
                            <p class="text-sm text-gray-500 max-w-xs mt-1">Saat ini tidak ada aset yang sedang dipinjam.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-b-2xl">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peminjam</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aset</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Batas Waktu</th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Waktu</th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($active as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-9 w-9 flex-shrink-0 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs border border-gray-200">
                                                        {{ substr($item->pegawai->nama_pegawai, 0, 1) }}
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-medium text-gray-900">{{ $item->pegawai->nama_pegawai }}</div>
                                                        <div class="text-xs text-gray-500">{{ $item->pegawai->nip_pegawai }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-col">
                                                    <span class="text-sm text-gray-900 font-medium">{{ $item->aset->nama_aset }}</span>
                                                    <span class="text-xs text-gray-400 font-mono">{{ $item->aset->kode_aset }}</span>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center text-sm text-gray-600">
                                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $deadline = \Carbon\Carbon::parse($item->tanggal_kembali);
                                                    $sisaHari = now()->diffInDays($deadline, false);
                                                    $isLate = $sisaHari < 0;
                                                @endphp

                                                @if($isLate)
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/10">
                                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                        Telat {{ abs(intval($sisaHari)) }} Hari
                                                    </span>
                                                @elseif($sisaHari == 0)
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/10">
                                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                        Deadline Hari Ini
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                        {{ intval($sisaHari) }} Hari Lagi
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" 
                                                    class="btn-return inline-flex items-center justify-center gap-2 rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 transition-all"
                                                    data-id="{{ $item->id }}"
                                                    data-name="{{ $item->aset->nama_aset }}">
                                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                                                    </svg>
                                                    Proses Pengembalian
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
                    @endif
                </div>

                <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <div class="overflow-x-auto rounded-b-2xl">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aset</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Akhir</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($history as $item)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->updated_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->pegawai->nama_pegawai }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $item->aset->nama_aset }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->status == 'kembali')
                                                <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Selesai</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($item->kondisi_pengembalian)
                                                <div class="flex items-center gap-2">
                                                    @if($item->kondisi_pengembalian == 'baik')
                                                        <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                                        <span class="text-gray-700">Baik / Normal</span>
                                                    @else
                                                        <div class="h-2 w-2 rounded-full bg-red-500"></div>
                                                        <span class="text-gray-700 capitalize">{{ $item->kondisi_pengembalian }}</span>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 1. SUCCESS NOTIFICATION (Toast) ---
        // Cek apakah ada session flash 'success' dari Controller Laravel
        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif


        // --- 2. LOGIC TOMBOL RETURN ---
        document.body.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-return');
            
            if (target) {
                e.preventDefault();
                const id = target.getAttribute('data-id');
                const namaAset = target.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Verifikasi Pengembalian',
                    html: `
                        <div class="text-left mt-2 space-y-4">
                            <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                                <p class="text-xs text-indigo-500 uppercase font-bold tracking-wider mb-1">Aset</p>
                                <p class="text-gray-900 font-bold text-lg leading-tight">${namaAset}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Fisik Barang</label>
                            </div>
                        </div>
                    `,
                    icon: 'info', // Menggunakan icon info standard
                    input: 'radio',
                    inputOptions: {
                        'baik': 'Baik (Normal)',
                        'rusak': 'Rusak (Perlu Perbaikan)',
                        'hilang': 'Hilang'
                    },
                    inputValue: 'baik',
                    inputValidator: (value) => {
                        if (!value) return 'Anda wajib memilih kondisi barang!'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    buttonsStyling: false,
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-gray-100 font-sans',
                        title: 'text-xl font-bold text-gray-900',
                        htmlContainer: 'text-gray-600',
                        confirmButton: 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 ml-2 focus:outline-none transition-colors',
                        cancelButton: 'text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors',
                        input: 'flex flex-col gap-2 mt-2 text-sm text-gray-700',
                        actions: 'mt-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const inputField = document.getElementById('input-kondisi-' + id);
                        const form = document.getElementById('form-return-' + id);
                        
                        if(inputField && form) {
                            inputField.value = result.value;
                            form.submit();
                        }
                    }
                });
            }
        });
    });
    </script>
</x-app-layout>