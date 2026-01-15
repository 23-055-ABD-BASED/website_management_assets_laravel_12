<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10 font-sans text-slate-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h2 class="text-2xl font-extrabold text-[#171717] tracking-tight">
                    {{ isset($aset) ? 'Edit Data Aset' : 'Input Aset Baru' }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    {{ isset($aset) ? 'Perbarui informasi aset yang sudah ada.' : 'Silakan isi formulir di bawah ini untuk mendaftarkan aset baru.' }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                
                <form method="POST"
                    action="{{ isset($aset) ? route('admin.aset.update', $aset) : route('admin.aset.store') }}"
                    class="p-6 md:p-8">

                    @csrf
                    @isset($aset)
                        @method('PUT')
                    @endisset

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">

                        <div class="col-span-1">
                            <label class="block text-sm font-bold text-[#171717] mb-2">
                                Kode Aset <span class="text-[#fd2800]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                </div>
                                <input type="text" name="kode_aset"
                                    class="pl-10 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50 focus:bg-white transition-colors"
                                    placeholder="Contoh: AST-2024-001"
                                    value="{{ old('kode_aset', $aset->kode_aset ?? '') }}"
                                    required>
                            </div>
                            <p class="mt-1 text-xs text-slate-400">Nomor unik identifikasi barang.</p>
                            @error('kode_aset') <p class="text-[#fd2800] text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-bold text-[#171717] mb-2">
                                Nama Barang <span class="text-[#fd2800]">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                </div>
                                <input type="text" name="nama_aset"
                                    class="pl-10 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50 focus:bg-white transition-colors"
                                    placeholder="Contoh: Laptop MacBook Pro M1"
                                    value="{{ old('nama_aset', $aset->nama_aset ?? '') }}"
                                    required>
                            </div>
                            <p class="mt-1 text-xs text-slate-400">Nama lengkap atau merek barang.</p>
                            @error('nama_aset') <p class="text-[#fd2800] text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-bold text-[#171717] mb-2">
                                Kategori
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                </div>
                                <input type="text" name="kategori_aset"
                                    class="pl-10 block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50 focus:bg-white transition-colors"
                                    placeholder="Contoh: Elektronik / Furniture"
                                    value="{{ old('kategori_aset', $aset->kategori_aset ?? '') }}">
                            </div>
                            @error('kategori_aset') <p class="text-[#fd2800] text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="hidden md:block"></div>

                        <div class="col-span-1">
                            <label class="block text-sm font-bold text-[#171717] mb-2">
                                Kondisi Fisik
                            </label>
                            <div class="relative">
                                <select name="kondisi_aset" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50 text-slate-700">
                                    <option value="baik" {{ old('kondisi_aset', $aset->kondisi_aset ?? '') == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak" {{ old('kondisi_aset', $aset->kondisi_aset ?? '') == 'rusak' ? 'selected' : '' }}>Rusak / Perlu Perbaikan</option>
                                </select>
                            </div>
                            <p class="mt-1 text-xs text-slate-400">Kondisi saat ini.</p>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-bold text-[#171717] mb-2">
                                Status Ketersediaan
                            </label>
                            <div class="relative">
                                <select name="status_aset" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-2.5 bg-slate-50 text-slate-700">
                                    <option value="tersedia" {{ old('status_aset', $aset->status_aset ?? '') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="digunakan" {{ old('status_aset', $aset->status_aset ?? '') == 'digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                                    <option value="rusak" {{ old('status_aset', $aset->status_aset ?? '') == 'rusak' ? 'selected' : '' }}>Tidak Dapat Dipakai</option>
                                </select>
                            </div>
                            <p class="mt-1 text-xs text-slate-400">Apakah barang bisa dipinjam?</p>
                        </div>

                    </div>
                    <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                        
                        <a href="{{ route('admin.aset.index') }}"
                            class="inline-flex justify-center items-center px-5 py-2.5 border border-slate-300 shadow-sm text-sm font-semibold rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-200 transition-all">
                            Batal
                        </a>

                        <button type="submit"
                            class="inline-flex justify-center items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-bold rounded-xl text-white bg-[#fd2800] hover:bg-[#171717] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#fd2800] transition-all transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            {{ isset($aset) ? 'Perbarui Data' : 'Simpan Aset' }}
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>