<x-app-layout>
    {{-- Import Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        .font-heading { font-family: 'Poppins', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="min-h-screen bg-[#F8F9FA] text-slate-600 font-sans pb-24">
        
        {{-- HEADER & STATS --}}
        <div class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm/50 bg-white/95 backdrop-blur-md">
            <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    {{-- Title --}}
                    <div>
                        <h2 class="text-xl font-bold text-[#171717] font-heading tracking-tight flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Katalog Aset
                        </h2>
                    </div>

                    {{-- Stats Pills --}}
                    <div class="flex items-center gap-3 overflow-x-auto no-scrollbar">
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg">
                            <span class="text-[10px] uppercase font-bold text-slate-400">Total</span>
                            <span class="text-sm font-bold text-[#171717]">{{ $stats['total'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-green-50 border border-green-100 rounded-lg">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="text-[10px] font-bold text-green-700 uppercase">Tersedia {{ $stats['tersedia'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-red-50 border border-red-100 rounded-lg">
                            <div class="w-2 h-2 rounded-full bg-[#fd2800]"></div>
                            <span class="text-[10px] font-bold text-red-700 uppercase">Rusak {{ $stats['rusak'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            {{-- FILTER TOOLBAR --}}
            <form action="{{ route('admin.aset.index') }}" method="GET" class="mb-8">
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col xl:flex-row gap-4 justify-between">
                    
                    {{-- Search --}}
                    <div class="relative w-full xl:w-1/4">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode aset..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-[#fd2800] focus:border-[#fd2800] transition-all">
                    </div>

                    {{-- Filters Group --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto overflow-x-auto">
                        
                        {{-- Filter Kategori --}}
                        <select name="kategori" onchange="this.form.submit()" class="w-full sm:w-auto pl-3 pr-8 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-[#fd2800] focus:border-[#fd2800] cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>

                        {{-- Filter Status --}}
                        <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto pl-3 pr-8 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-[#fd2800] focus:border-[#fd2800] cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="digunakan" {{ request('status') == 'digunakan' ? 'selected' : '' }}>Digunakan</option>
                            <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>

                        {{-- Filter Kondisi --}}
                        <select name="kondisi" onchange="this.form.submit()" class="w-full sm:w-auto pl-3 pr-8 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-[#fd2800] focus:border-[#fd2800] cursor-pointer">
                            <option value="">Semua Kondisi</option>
                            <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak" {{ request('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>

                        {{-- Reset Button --}}
                        @if(request()->hasAny(['search', 'kategori', 'status', 'kondisi']))
                            <a href="{{ route('admin.aset.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>

                    {{-- Add Button --}}
                    <div class="w-full xl:w-auto border-t xl:border-t-0 pt-4 xl:pt-0">
                        <a href="{{ route('admin.aset.create') }}" 
                           class="flex items-center justify-center gap-2 w-full bg-[#171717] hover:bg-[#fd2800] text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-gray-900/10 hover:shadow-red-500/30">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            <span>Tambah Baru</span>
                        </a>
                    </div>
                </div>
            </form>

            {{-- ASSET GRID (5 Columns) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5">
                
                @forelse($aset as $a)
                    <div class="group bg-white rounded-2xl border border-slate-200 hover:border-[#fd2800]/50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 flex flex-col h-full relative overflow-hidden">
                        
                        {{-- Top Stripe --}}
                        <div class="h-1.5 w-full {{ $a->kondisi_aset == 'baik' ? 'bg-gradient-to-r from-green-400 to-green-500' : 'bg-gradient-to-r from-red-500 to-[#fd2800]' }}"></div>

                        <div class="p-5 flex flex-col h-full">
                            
                            {{-- Header: Code & Category --}}
                            <div class="flex justify-between items-start mb-3">
                                <div class="bg-slate-50 border border-slate-100 px-2 py-1 rounded text-[10px] font-mono font-bold text-slate-500 tracking-wide">
                                    {{ $a->kode_aset }}
                                </div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    {{ $a->kategori_aset }}
                                </div>
                            </div>

                            {{-- Title --}}
                            <div class="mb-4">
                                <h3 class="text-[15px] font-bold text-[#171717] leading-snug group-hover:text-[#fd2800] transition-colors line-clamp-2">
                                    {{ $a->nama_aset }}
                                </h3>
                            </div>

                            {{-- Info Grid --}}
                            <div class="mt-auto grid grid-cols-2 gap-2 text-xs border-t border-slate-50 pt-3 mb-4">
                                {{-- Status --}}
                                <div>
                                    <p class="text-[10px] uppercase text-slate-400 font-bold mb-0.5">Status</p>
                                    @if($a->status_aset == 'tersedia')
                                        <span class="inline-flex items-center gap-1.5 font-bold text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Tersedia
                                        </span>
                                    @elseif($a->status_aset == 'digunakan')
                                        <span class="inline-flex items-center gap-1.5 font-bold text-amber-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Dipakai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 font-bold text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> {{ ucfirst($a->status_aset) }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Kondisi --}}
                                <div class="text-right">
                                    <p class="text-[10px] uppercase text-slate-400 font-bold mb-0.5">Kondisi</p>
                                    @if($a->kondisi_aset == 'baik')
                                        <span class="font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">Baik</span>
                                    @else
                                        <span class="font-bold text-white bg-[#fd2800] px-2 py-0.5 rounded">Rusak</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-2">
                                @if($a->status_aset === 'digunakan')
                                    {{-- EDIT DISABLED --}}
                                    <button type="button"
                                        class="flex-1 py-2 rounded-lg bg-slate-100 text-slate-400 text-xs font-bold text-center border border-slate-200 cursor-not-allowed"
                                        title="Aset sedang digunakan">
                                        Digunakan
                                    </button>

                                    {{-- DELETE DISABLED --}}
                                    <button type="button"
                                        class="px-3 py-2 rounded-lg bg-slate-100 text-slate-400 border border-slate-200 cursor-not-allowed"
                                        title="Aset sedang digunakan">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @else
                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.aset.edit', $a) }}"
                                    class="flex-1 py-2 rounded-lg bg-slate-50 text-slate-600 text-xs font-bold text-center border border-slate-200 hover:bg-white hover:border-slate-300 hover:text-[#171717] transition-all">
                                        Edit
                                    </a>

                                    {{-- DELETE --}}
                                    <form method="POST" action="{{ route('admin.aset.destroy', $a) }}" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-2 rounded-lg bg-white text-slate-400 border border-slate-200 hover:bg-red-50 hover:text-[#fd2800] hover:border-red-100 transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#171717]">Data Tidak Ditemukan</h3>
                        <p class="text-slate-500 text-sm mt-1">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                        <a href="{{ route('admin.aset.index') }}" class="inline-block mt-4 text-[#fd2800] text-sm font-bold hover:underline">Reset Filter</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /**
     * Konfigurasi Dasar SweetAlert2 agar Setema dengan Asetu
     */
    const AsetuCustomStyle = {
        popup: 'rounded-2xl shadow-2xl border border-slate-100 font-sans',
        title: 'text-lg font-bold text-[#171717]',
        confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-bold transition-all mx-1',
        cancelButton: 'rounded-xl px-6 py-2.5 text-sm font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all mx-1'
    };

    /**
     * 1. Notifikasi Berhasil (Compact Toast di Tengah Atas)
     * Muncul setelah Tambah, Edit, atau Hapus berhasil.
     */
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: "{{ session('success') }}",
            toast: true,
            position: 'top', // Di tengah atas layar
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            iconColor: '#fd2800',
            background: '#ffffff',
            customClass: {
                popup: 'rounded-xl shadow-lg border border-slate-100 mt-4',
                title: 'text-sm font-bold text-slate-700'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    @endif

    /**
     * 2. Notifikasi Gagal (Elegant Pop-up)
     */
    @if(session('error') || $errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops! Terjadi Kesalahan',
            text: "{{ session('error') ?? 'Mohon periksa kembali inputan Anda.' }}",
            iconColor: '#fd2800',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#171717', // Hitam elegan
            buttonsStyling: false,
            customClass: {
                popup: AsetuCustomStyle.popup,
                title: AsetuCustomStyle.title,
                confirmButton: AsetuCustomStyle.confirmButton + ' bg-[#171717] text-white hover:bg-slate-800'
            }
        });
    @endif

    /**
     * 3. Logic Konfirmasi Hapus (User Friendly)
     */
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Aset Ini?',
                text: "Data yang sudah dihapus tidak dapat dipulihkan kembali.",
                icon: 'warning',
                iconColor: '#fd2800',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batalkan',
                confirmButtonColor: '#fd2800', // Merah Asetu
                cancelButtonColor: '#f1f5f9',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: AsetuCustomStyle.popup,
                    title: AsetuCustomStyle.title + ' text-xl',
                    htmlContainer: 'text-sm text-slate-500',
                    confirmButton: AsetuCustomStyle.confirmButton + ' bg-[#fd2800] text-white hover:bg-red-700 shadow-md shadow-red-200',
                    cancelButton: AsetuCustomStyle.cancelButton
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
</x-app-layout>