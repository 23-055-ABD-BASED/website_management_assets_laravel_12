<x-app-layout>
    {{-- Container utama yang responsif --}}
    <div class="min-h-screen bg-[#F8F9FA] font-sans pb-24 px-4">
        
        <div class="max-w-4xl mx-auto py-6 sm:py-10">
            {{-- Card Form --}}
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                
                {{-- Header Form --}}
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2.5 bg-slate-100 rounded-xl text-[#fd2800]">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-[#171717]">
                        {{ isset($aset) ? 'Edit Data Aset' : 'Tambah Aset Baru' }}
                    </h2>
                </div>

                <form 
                    id="formAset"
                    method="POST" 
                    action="{{ isset($aset) ? route('admin.aset.update', $aset->id_aset) : route('admin.aset.store') }}"
                    class="space-y-6"
                >
                    @csrf
                    @if(isset($aset))
                        @method('PUT')
                    @endif

                    {{-- Grid Input --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-bold text-slate-700">
                                Kode Aset (4 Digit Terakhir)
                            </label>
                            <input 
                                type="text" 
                                name="kode_aset_suffix" 
                                value="{{ old('kode_aset_suffix', isset($aset) ? substr($aset->kode_aset, -4) : '') }}" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#fd2800]/20 focus:border-[#fd2800] outline-none transition-all placeholder:text-slate-400"
                                placeholder="Contoh: 0001"
                                required
                            >
                            @error('kode_aset_suffix')
                                <p class="text-[#fd2800] text-xs font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-bold text-slate-700">
                                Nama Aset
                            </label>
                            <input 
                                type="text" 
                                name="nama_aset" 
                                value="{{ old('nama_aset', $aset->nama_aset ?? '') }}" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#fd2800]/20 focus:border-[#fd2800] outline-none transition-all placeholder:text-slate-400"
                                placeholder="Masukkan nama aset"
                                required
                            >
                            @error('nama_aset')
                                <p class="text-[#fd2800] text-xs font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-bold text-slate-700">
                                Kategori Aset
                            </label>
                            <select 
                                name="kategori_aset" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#fd2800]/20 focus:border-[#fd2800] outline-none transition-all cursor-pointer"
                                required
                            >
                                <option value="" disabled {{ !isset($aset) ? 'selected' : '' }}>Pilih Kategori</option>
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori }}" @selected(old('kategori_aset', $aset->kategori_aset ?? '') === $kategori)>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-bold text-slate-700">
                                Kondisi Aset
                            </label>
                            <select 
                                name="kondisi_aset" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#fd2800]/20 focus:border-[#fd2800] outline-none transition-all cursor-pointer"
                                required
                            >
                                <option value="baik" @selected(old('kondisi_aset', $aset->kondisi_aset ?? '') === 'baik')>Baik</option>
                                <option value="rusak" @selected(old('kondisi_aset', $aset->kondisi_aset ?? '') === 'rusak')>Rusak</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">
                            Status Aset
                        </label>
                        <select 
                            name="status_aset" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#fd2800]/20 focus:border-[#fd2800] outline-none transition-all cursor-pointer"
                            required
                        >
                            <option value="tersedia" @selected(old('status_aset', $aset->status_aset ?? '') === 'tersedia')>Tersedia</option>
                            <option value="digunakan" @selected(old('status_aset', $aset->status_aset ?? '') === 'digunakan')>Digunakan</option>
                            <option value="rusak" @selected(old('status_aset', $aset->status_aset ?? '') === 'rusak')>Rusak (Non-Aktif)</option>
                        </select>
                        <p class="text-[11px] text-slate-400 italic mt-1.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/></svg>
                            Aset rusak tidak diperbolehkan berstatus tersedia.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t border-slate-100">
                        <button 
                            type="button"
                            onclick="confirmAction()"
                            class="w-full sm:flex-1 bg-[#171717] hover:bg-[#fd2800] text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-gray-900/10 hover:shadow-red-500/30 flex justify-center items-center gap-2"
                        >
                            <span>{{ isset($aset) ? 'Simpan Perubahan' : 'Daftarkan Aset' }}</span>
                        </button>
                        
                        <a 
                            href="{{ route('admin.aset.index') }}" 
                            class="w-full sm:w-auto px-8 py-3.5 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors text-center"
                        >
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS NOTIFIKASI --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        /**
         * Konfigurasi Dasar SweetAlert2 Setema Asetu
         */
        const AsetuTheme = {
            popup: 'rounded-2xl shadow-2xl border border-slate-100 font-sans',
            title: 'text-lg font-bold text-[#171717]',
            confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-bold transition-all mx-1',
            cancelButton: 'rounded-xl px-6 py-2.5 text-sm font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all mx-1'
        };

        /**
         * 1. Konfirmasi Sebelum Submit
         */
        function confirmAction() {
            Swal.fire({
                title: 'Konfirmasi Data',
                text: "{{ isset($aset) ? 'Simpan perubahan pada data aset ini?' : 'Pastikan data aset yang Anda masukkan sudah benar.' }}",
                icon: 'question',
                iconColor: '#171717',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Cek Kembali',
                confirmButtonColor: '#171717',
                cancelButtonColor: '#f1f5f9',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: AsetuTheme.popup,
                    title: AsetuTheme.title,
                    htmlContainer: 'text-sm text-slate-500',
                    confirmButton: AsetuTheme.confirmButton + ' bg-[#171717] text-white hover:bg-slate-800',
                    cancelButton: AsetuTheme.cancelButton
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formAset').submit();
                }
            });
        }

        /**
         * 2. Notifikasi Berhasil (Toast Tengah Atas)
         * Menangkap redirect dari controller (Tambah/Edit)
         */
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: "{{ session('success') }}",
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                iconColor: '#fd2800',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-xl shadow-lg border border-slate-100 mt-4',
                    title: 'text-sm font-bold text-slate-700'
                }
            });
        @endif

        /**
         * 3. Notifikasi Gagal (Elegant Pop-up)
         */
        @if(session('error') || $errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: "{{ session('error') ?? 'Terjadi kesalahan pada data yang diinput.' }}",
                iconColor: '#fd2800',
                confirmButtonText: 'Pahami',
                confirmButtonColor: '#fd2800',
                buttonsStyling: false,
                customClass: {
                    popup: AsetuTheme.popup,
                    title: AsetuTheme.title,
                    confirmButton: AsetuTheme.confirmButton + ' bg-[#fd2800] text-white hover:bg-red-700'
                }
            });
        @endif
    </script>
</x-app-layout>