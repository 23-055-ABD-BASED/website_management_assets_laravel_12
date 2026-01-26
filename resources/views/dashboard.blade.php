<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="relative bg-slate-900 pb-32 pt-12">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute left-0 top-0 h-full w-full bg-gradient-to-r from-blue-600 to-indigo-900 opacity-50"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-white sm:truncate sm:text-3xl sm:tracking-tight">
                        Halo, {{ auth()->user()->username ?? 'User' }}
                    </h2>
                    <p class="mt-2 text-sm text-blue-100">
                        Selamat datang di Sistem Manajemen Aset.
                    </p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <span class="inline-flex items-center rounded-md bg-white/10 px-3 py-2 text-sm font-medium text-white ring-1 ring-inset ring-white/20">
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="-mt-24 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-12 relative z-10" x-data="{ showLoanModal: false }">
        
        @if (!auth()->user()->pegawai)
            <div class="bg-white rounded-xl shadow-xl overflow-hidden text-center py-16 px-6">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                    <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>                  
                </div>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Lengkapi Profil Anda</h3>
                <p class="mt-1 text-gray-500 max-w-sm mx-auto">Data kepegawaian diperlukan untuk mengajukan peminjaman aset.</p>
                <div class="mt-6">
                    <a href="{{ route('pegawai.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-all duration-200">
                        Lengkapi Data Sekarang
                    </a>
                </div>
            </div>
        @else
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="px-6 py-5 bg-gray-50/50 border-b border-gray-100">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Profil Saya</h3>
                        </div>
                        <div class="px-6 py-6 space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Nama</label>
                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->pegawai->nama_pegawai }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">NIP</label>
                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->pegawai->nip_pegawai }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Jabatan</label>
                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->pegawai->jabatan }}</p>
                            </div>
                            <div class="pt-2">
                                <span class="inline-flex items-center gap-x-1.5 rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset 
                                    {{ auth()->user()->pegawai->status_pegawai === 'aktif' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/10' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ auth()->user()->pegawai->status_pegawai === 'aktif' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    Status: {{ strtoupper(auth()->user()->pegawai->status_pegawai) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-xl shadow-lg p-6 text-white relative overflow-hidden group">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
                        <h3 class="text-lg font-bold relative z-10">Ajukan Peminjaman</h3>
                        <p class="text-sm text-indigo-100 mt-1 mb-4 relative z-10">Butuh peralatan kantor? Ajukan form di sini.</p>
                        <button @click="showLoanModal = true" class="w-full relative z-10 flex items-center justify-center rounded-lg bg-white text-indigo-600 px-4 py-2.5 text-sm font-bold shadow-md hover:bg-indigo-50 transition-all">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Buat Pengajuan Baru
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-white">Aset Aktif Anda</h3>
                        <a href="{{ route('peminjaman.index') }}" class="text-sm text-blue-200 hover:text-white hover:underline">Lihat Riwayat Lengkap &rarr;</a>
                    </div>

                    @php
                        $activeLoans = $riwayatPinjam->filter(function ($item) {
                            return in_array($item->status, ['pending', 'disetujui']);
                        });
                    @endphp

                    <div class="flex overflow-x-auto pb-6 gap-5 snap-x scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
                        
                        @forelse($activeLoans as $item)
                            <div class="snap-center shrink-0 w-80 bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
                                <div class="h-2 w-full {{ $item->status == 'pending' ? 'bg-yellow-400' : 'bg-green-500' }}"></div>
                                
                                <div class="p-5 flex-1 flex flex-col">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="p-2 rounded-lg {{ $item->status == 'pending' ? 'bg-yellow-50 text-yellow-600' : 'bg-green-50 text-green-600' }}">
                                            @if($item->status == 'pending')
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            @else
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium 
                                            {{ $item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>

                                    <h4 class="text-lg font-bold text-gray-900 mb-1 line-clamp-1" title="{{ $item->aset->nama_aset }}">
                                        {{ $item->aset->nama_aset }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mb-4">{{ $item->aset->kode_aset }}</p>

                                    <div class="space-y-2 mt-auto">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            <span>
                                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') }} s/d {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-start text-sm text-gray-600">
                                            <svg class="mr-2 h-4 w-4 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="line-clamp-2 text-xs italic">{{ $item->alasan }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="w-full bg-white rounded-xl shadow-sm border border-dashed border-gray-300 p-8 text-center flex flex-col items-center justify-center min-h-[250px]">
                                <div class="h-16 w-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h3 class="text-gray-900 font-medium">Tidak ada aset aktif</h3>
                                <p class="text-gray-500 text-sm mt-1 max-w-xs">Anda tidak sedang meminjam aset apapun saat ini. Klik tombol di kiri untuk mengajukan.</p>
                            </div>
                        @endforelse

                    </div>
                    @if($activeLoans->count() > 2)
                        <div class="flex justify-end pr-2">
                            <p class="text-xs text-blue-200 animate-pulse flex items-center gap-1">
                                Geser untuk melihat lainnya &rarr;
                            </p>
                        </div>
                    @endif
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
                     class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" 
                     @click="showLoanModal = false"></div>

                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showLoanModal"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        
                        <div class="bg-indigo-600 px-4 py-3 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-base font-semibold leading-6 text-white" id="modal-title">Form Pengajuan Peminjaman</h3>
                                <button @click="showLoanModal = false" class="text-indigo-200 hover:text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <form action="{{ route('peminjaman.store') }}" method="POST">
                            @csrf
                            <div class="px-4 py-5 sm:p-6">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Nama Peminjam</label>
                                            <input type="text" value="{{ auth()->user()->pegawai->nama_pegawai }}" readonly 
                                                class="mt-1 block w-full rounded-md border-gray-200 bg-gray-100 text-gray-500 shadow-sm sm:text-sm cursor-not-allowed">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">NIP</label>
                                            <input type="text" value="{{ auth()->user()->pegawai->nip_pegawai }}" readonly 
                                                class="mt-1 block w-full rounded-md border-gray-200 bg-gray-100 text-gray-500 shadow-sm sm:text-sm cursor-not-allowed">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="id_aset" class="block text-sm font-medium leading-6 text-gray-900">Pilih Barang / Aset</label>
                                        <select name="id_aset" id="id_aset" required class="mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            <label for="tanggal_pinjam" class="block text-sm font-medium leading-6 text-gray-900">Mulai Pinjam</label>
                                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" required class="mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                        <div>
                                            <label for="tanggal_kembali" class="block text-sm font-medium leading-6 text-gray-900">Rencana Kembali</label>
                                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" required class="mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="alasan" class="block text-sm font-medium leading-6 text-gray-900">Keperluan / Alasan</label>
                                        <textarea name="alasan" id="alasan" rows="3" required placeholder="Contoh: Untuk kegiatan presentasi rapat bulanan..." class="mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto">
                                    Kirim Pengajuan
                                </button>
                                <button type="button" @click="showLoanModal = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
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
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4f46e5',
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Periksa Inputan',
                html: '<ul class="text-left text-sm">@foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#f59e0b'
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