<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="relative bg-[#171717] pb-32 pt-12 shadow-2xl">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute left-0 top-0 h-full w-full bg-gradient-to-br from-[#fd2800] via-[#171717] to-[#171717] opacity-20"></div>
            <div class="absolute right-0 bottom-0 h-64 w-64 bg-[#fd2800] opacity-10 blur-3xl rounded-full translate-y-1/2 translate-x-1/2"></div>
        </div>
        
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h2 class="text-3xl font-extrabold leading-7 text-white sm:truncate sm:text-4xl sm:tracking-tight tracking-wide">
                        Halo, <span class="text-[#fd2800]">{{ auth()->user()->username ?? 'User' }}</span>
                    </h2>
                    <p class="mt-2 text-sm text-[#ededed]/70">
                        Selamat datang di Sistem Manajemen Aset.
                    </p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <div class="inline-flex items-center rounded-lg bg-[#444444]/50 backdrop-blur-md px-4 py-2 text-sm font-medium text-white ring-1 ring-inset ring-white/10 shadow-lg">
                        <svg class="mr-2 h-5 w-5 text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="-mt-24 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-12 relative z-10" x-data="{ showLoanModal: false }">
        
        @if (!auth()->user()->pegawai)
            <div class="bg-[#ededed] rounded-2xl shadow-2xl overflow-hidden text-center py-16 px-6 border border-gray-200 relative group">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#fd2800]"></div>
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#fd2800]/10 group-hover:bg-[#fd2800]/20 transition-colors duration-300">
                    <svg class="h-10 w-10 text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>                  
                </div>
                <h3 class="mt-6 text-xl font-bold text-[#171717]">Lengkapi Profil Anda</h3>
                <p class="mt-2 text-[#444444] max-w-sm mx-auto">Data kepegawaian diperlukan untuk mengajukan peminjaman aset kantor.</p>
                <div class="mt-8">
                    <a href="{{ route('pegawai.create') }}" class="inline-flex items-center rounded-lg bg-[#fd2800] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-[#fd2800]/30 hover:bg-[#d62200] hover:-translate-y-1 transition-all duration-200">
                        Lengkapi Data Sekarang
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        @else
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1 space-y-6">
                    
                    <div class="bg-[#ededed] rounded-2xl shadow-xl overflow-hidden border border-white/50 relative">
                        <div class="absolute top-0 left-0 w-1 h-full bg-[#fd2800]"></div>
                        <div class="px-6 py-5 border-b border-[#444444]/10 bg-white/50">
                            <h3 class="text-lg font-bold leading-6 text-[#171717] flex items-center">
                                <span class="bg-[#171717] text-white p-1 rounded mr-2">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </span>
                                Profil Saya
                            </h3>
                        </div>
                        <div class="px-6 py-6 space-y-5">
                            <div class="group">
                                <label class="text-xs font-bold text-[#fd2800] uppercase tracking-wider">Nama</label>
                                <p class="text-base font-bold text-[#171717] group-hover:translate-x-1 transition-transform">{{ auth()->user()->pegawai->nama_pegawai }}</p>
                            </div>
                            <div class="group">
                                <label class="text-xs font-bold text-[#fd2800] uppercase tracking-wider">NIP</label>
                                <p class="text-base font-bold text-[#171717] font-mono group-hover:translate-x-1 transition-transform">{{ auth()->user()->pegawai->nip_pegawai }}</p>
                            </div>
                            <div class="group">
                                <label class="text-xs font-bold text-[#fd2800] uppercase tracking-wider">Jabatan</label>
                                <p class="text-base font-bold text-[#171717] group-hover:translate-x-1 transition-transform">{{ auth()->user()->pegawai->jabatan }}</p>
                            </div>
                            <div class="pt-2 border-t border-[#444444]/10">
                                <span class="inline-flex items-center gap-x-1.5 rounded-full px-3 py-1 text-xs font-bold ring-1 ring-inset shadow-sm
                                    {{ auth()->user()->pegawai->status_pegawai === 'aktif' ? 'bg-green-100 text-green-700 ring-green-600/20' : 'bg-red-100 text-red-700 ring-red-600/10' }}">
                                    <span class="h-2 w-2 rounded-full {{ auth()->user()->pegawai->status_pegawai === 'aktif' ? 'bg-green-600' : 'bg-red-600 animate-pulse' }}"></span>
                                    STATUS: {{ strtoupper(auth()->user()->pegawai->status_pegawai) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-[#fd2800] to-[#b91c00] rounded-2xl shadow-xl p-6 text-white relative overflow-hidden group hover:shadow-2xl hover:shadow-[#fd2800]/40 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-40 h-40 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-500 blur-sm"></div>
                        <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 bg-black/10 rounded-full blur-sm"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-xl font-black italic tracking-wide">AJUKAN PEMINJAMAN</h3>
                            <p class="text-sm text-white/90 mt-2 mb-6 font-medium">Butuh peralatan kantor untuk menunjang kinerja? Buat pengajuan baru sekarang.</p>
                            
                            <button @click="showLoanModal = true" class="w-full group flex items-center justify-center rounded-xl bg-[#171717] text-white border border-white/10 px-4 py-3 text-sm font-bold shadow-lg hover:bg-white hover:text-[#fd2800] transition-all duration-300">
                                <svg class="mr-2 h-5 w-5 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Buat Pengajuan Baru
                            </button>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-6">
                        <h3
                            class="text-xl font-bold
                                text-[#fd2800] lg:text-white
                                flex items-center gap-2">
                            <span class="w-2 h-8 bg-[#fd2800] rounded-sm"></span>
                            Aset Aktif Anda
                        </h3>
                        <a href="{{ route('peminjaman.index') }}" class="group flex items-center text-sm font-medium text-[#ededed] hover:text-[#fd2800] transition-colors">
                            Lihat Riwayat
                            <svg class="ml-1 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>

                    @php
                        $activeLoans = $riwayatPinjam->filter(function ($item) {
                            return in_array($item->status, ['pending', 'disetujui']);
                        });
                    @endphp

                    <div class="flex overflow-x-auto pb-8 gap-6 snap-x scrollbar-thin scrollbar-thumb-[#fd2800] scrollbar-track-[#444444]/30">
                        
                        @forelse($activeLoans as $item)
                            <div class="snap-center shrink-0 w-80 bg-[#ededed] rounded-2xl shadow-lg border border-transparent hover:border-[#fd2800] overflow-hidden hover:shadow-2xl hover:shadow-[#fd2800]/10 transition-all duration-300 flex flex-col group">
                                <div class="h-1.5 w-full {{ $item->status == 'pending' ? 'bg-yellow-400' : 'bg-[#fd2800]' }}"></div>
                                
                                <div class="p-6 flex-1 flex flex-col relative">
                                    <div class="absolute right-[-10px] top-[-10px] text-[#171717]/5 transform rotate-12 pointer-events-none">
                                         <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    </div>

                                    <div class="flex justify-between items-start mb-4 relative z-10">
                                        <div class="p-2 rounded-lg shadow-sm {{ $item->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-[#171717] text-white' }}">
                                            @if($item->status == 'pending')
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            @else
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold uppercase tracking-wide shadow-sm
                                            {{ $item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-[#fd2800] text-white' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>

                                    <h4 class="text-xl font-black text-[#171717] mb-0.5 line-clamp-1 relative z-10" title="{{ $item->aset->nama_aset }}">
                                        {{ $item->aset->nama_aset }}
                                    </h4>
                                    <p class="text-xs font-mono text-[#fd2800] mb-5 relative z-10">{{ $item->aset->kode_aset }}</p>

                                    <div class="space-y-3 mt-auto relative z-10 bg-white/60 p-3 rounded-xl backdrop-blur-sm">
                                        <div class="flex items-center text-sm text-[#444444]">
                                            <svg class="mr-2 h-4 w-4 text-[#fd2800]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            <span class="font-medium">
                                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-start text-sm text-[#444444]">
                                            <svg class="mr-2 h-4 w-4 text-[#fd2800] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="line-clamp-2 text-xs italic">{{ $item->alasan }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="w-full bg-[#171717]/50 rounded-2xl shadow-inner border border-dashed border-[#444444] p-8 text-center flex flex-col items-center justify-center min-h-[250px]">
                                <div class="h-16 w-16 bg-[#444444] rounded-full flex items-center justify-center mb-4">
                                    <svg class="h-8 w-8 text-[#ededed]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h3 class="text-white font-bold text-lg">Tidak ada aset aktif</h3>
                                <p class="text-[#ededed]/60 text-sm mt-1 max-w-xs">Anda tidak sedang meminjam aset apapun saat ini.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>

            <div x-show="showLoanModal" 
                 style="display: none;"
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 aria-labelledby="modal-title" role="dialog" aria-modal="true">
                
                <div x-show="showLoanModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-[#171717]/90 backdrop-blur-sm transition-opacity" 
                     @click="showLoanModal = false"></div>

                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showLoanModal"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#fd2800]/20">
                        
                        <div class="bg-[#fd2800] px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold leading-6 text-white flex items-center gap-2" id="modal-title">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                    Form Pengajuan Peminjaman
                                </h3>
                                <button @click="showLoanModal = false" class="text-white/80 hover:text-white transition-colors bg-white/20 rounded-full p-1 hover:bg-white/30">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <form action="{{ route('peminjaman.store') }}" method="POST">
                            @csrf
                            <div class="px-6 py-6 bg-[#ededed]">
                                <div class="space-y-5">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-[#444444] uppercase mb-1">Nama Peminjam</label>
                                            <input type="text" value="{{ auth()->user()->pegawai->nama_pegawai }}" readonly 
                                                class="block w-full rounded-lg border-gray-300 bg-gray-200 text-[#171717] shadow-sm sm:text-sm cursor-not-allowed font-medium">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-[#444444] uppercase mb-1">NIP</label>
                                            <input type="text" value="{{ auth()->user()->pegawai->nip_pegawai }}" readonly 
                                                class="block w-full rounded-lg border-gray-300 bg-gray-200 text-[#171717] shadow-sm sm:text-sm cursor-not-allowed font-medium">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="id_aset" class="block text-sm font-bold leading-6 text-[#171717]">Pilih Barang / Aset</label>
                                        <select name="id_aset" id="id_aset" required class="mt-1 block w-full rounded-lg border-gray-300 py-2 text-[#171717] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm sm:leading-6">
                                            <option value="" disabled selected>-- Pilih Aset Tersedia --</option>
                                            @foreach($assets as $aset)
                                                <option value="{{ $aset->id_aset }}">
                                                    {{ $aset->nama_aset }} ({{ $aset->kode_aset }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="tanggal_pinjam" class="block text-sm font-bold leading-6 text-[#171717]">Mulai Pinjam</label>
                                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" required class="mt-1 block w-full rounded-lg border-gray-300 py-2 text-[#171717] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="tanggal_kembali" class="block text-sm font-bold leading-6 text-[#171717]">Rencana Kembali</label>
                                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" required class="mt-1 block w-full rounded-lg border-gray-300 py-2 text-[#171717] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="alasan" class="block text-sm font-bold leading-6 text-[#171717]">Keperluan / Alasan</label>
                                        <textarea name="alasan" id="alasan" rows="3" required placeholder="Contoh: Untuk kegiatan presentasi rapat bulanan..." class="mt-1 block w-full rounded-lg border-gray-300 py-2 text-[#171717] shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-200">
                                <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-[#fd2800] px-4 py-2.5 text-sm font-bold text-white shadow-md hover:bg-[#d62200] sm:ml-3 sm:w-auto transition-colors">
                                    Kirim Pengajuan
                                </button>
                                <button type="button" @click="showLoanModal = false" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-bold text-[#444444] shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @endif
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Custom Style for SweetAlert to match theme
        const swalCustom = Swal.mixin({
            confirmButtonColor: '#fd2800',
            cancelButtonColor: '#444444',
            background: '#ededed',
            color: '#171717'
        });

        @if(session('success'))
            swalCustom.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000
            });
        @endif

        @if(session('error'))
            swalCustom.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        @endif

        @if($errors->any())
            swalCustom.fire({
                icon: 'warning',
                title: 'Periksa Inputan',
                html: '<ul class="text-left text-sm font-medium">@foreach($errors->all() as $error)<li class="mb-1 text-[#fd2800]">• {{ $error }}</li>@endforeach</ul>',
            });
        @endif

        @if ($errors->has('peminjaman'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Bisa Mengajukan',
                text: '{{ $errors->first('peminjaman') }}',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#fd2800',
                allowOutsideClick: false
            });
        });
        </script>
        @endif

    });
</script>