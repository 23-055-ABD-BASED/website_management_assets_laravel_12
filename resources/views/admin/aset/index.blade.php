<x-app-layout>
    <div class="min-h-screen bg-gray-50 text-slate-600 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-[#171717] tracking-tight">
                        Manajemen Aset
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Daftar inventaris dan perlengkapan dinas.
                    </p>
                </div>

                <a href="{{ route('admin.aset.create') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-[#fd2800] hover:bg-[#171717] text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-red-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Aset Baru
                </a>
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        
                        <thead class="bg-slate-50/50 border-b border-slate-100 text-xs uppercase text-slate-500 font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Kode Aset</th>
                                <th class="px-6 py-4">Nama Barang</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Kondisi</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($aset as $a)
                                <tr class="hover:bg-slate-50/80 transition duration-150 group">
                                    
                                    {{-- Kode --}}
                                    <td class="px-6 py-4 font-mono text-xs font-semibold text-[#fd2800]">
                                        {{ $a->kode_aset }}
                                    </td>

                                    {{-- Nama --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                            </div>
                                            <span class="font-medium text-[#171717]">{{ $a->nama_aset }}</span>
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $a->kategori_aset }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($a->status_aset == 'tersedia')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Tersedia
                                            </span>
                                        @elseif($a->status_aset == 'digunakan')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Digunakan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> {{ ucfirst($a->status_aset) }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kondisi --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($a->kondisi_aset == 'baik')
                                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded-md border border-slate-200">
                                                Baik
                                            </span>
                                        @else
                                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-md border border-red-200">
                                                {{ ucfirst($a->kondisi_aset) }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200">
                                            
                                            {{-- Edit --}}
                                            <a href="{{ route('admin.aset.edit', $a) }}" 
                                               class="p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition shadow-sm"
                                               title="Edit Data">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>

                                            {{-- Delete (Form Class added) --}}
                                            <form method="POST" action="{{ route('admin.aset.destroy', $a) }}" class="form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition shadow-sm"
                                                        title="Hapus Data">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- Empty State --}}
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">Belum ada data aset.</p>
                                            <p class="text-xs text-slate-400 mt-1">Silakan tambahkan aset baru untuk memulai.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($aset, 'links') && $aset->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                        {{ $aset->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- ========================================== --}}
    {{-- SWEETALERT2 INTEGRATION --}}
    {{-- ========================================== --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Logic Tombol Hapus (Dialog Konfirmasi)
        const deleteForms = document.querySelectorAll('.form-delete');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Hapus Aset?',
                    text: "Data tidak dapat dikembalikan!",
                    icon: 'warning',
                    iconColor: '#fd2800',
                    background: '#ffffff',
                    color: '#171717',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    width: '400px',
                    
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100 font-sans',
                        title: 'text-lg font-bold text-[#171717]',
                        htmlContainer: 'text-sm text-slate-500',
                        confirmButton: 'bg-[#fd2800] text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg hover:bg-[#171717] transition-all focus:ring-0 border-0',
                        cancelButton: 'bg-white text-slate-600 px-4 py-2 rounded-xl text-sm font-bold border border-slate-200 hover:bg-slate-50 transition-all focus:ring-0 mr-3'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // 2. Logic Notifikasi Sukses (Compact Toast)
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            iconColor: '#fd2800',
            background: '#ffffff',
            color: '#171717',
            width: 380,
            showConfirmButton: false,
            timer: 2200,
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-2xl shadow-xl border border-slate-100 font-sans',
                title: 'text-lg font-bold text-[#171717]',
                htmlContainer: 'text-sm text-slate-500'
            }
        });
        @endif

</script>
</x-app-layout>