<x-app-layout>
    {{-- Main Container: White Background & Decorative Elements --}}
    <div class="min-h-screen bg-white font-sans text-[#444444] relative overflow-hidden py-10">

        {{-- Decorative Blobs (Konsisten dengan Dashboard) --}}
        <div class="absolute top-0 left-0 -mt-20 -ml-20 w-96 h-96 bg-[#ededed] opacity-40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 -mb-20 -mr-20 w-80 h-80 bg-[#fd2800] opacity-5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- 1. HEADER SECTION --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-[#171717]">
                        Edit Data <span class="text-[#fd2800]">Pegawai</span>
                    </h2>
                    <p class="mt-2 text-[#444444]">
                        Perbarui informasi profil dan jabatan pegawai.
                    </p>
                </div>
                <a href="{{ route('pegawai.index') }}" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-[#ededed] text-[#171717] font-bold text-sm hover:bg-[#171717] hover:text-white transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>

            {{-- 2. FORM CARD --}}
            <div class="bg-white rounded-[2rem] border border-[#ededed] shadow-2xl shadow-gray-200/50 overflow-hidden relative">
                
                {{-- Top Stripe Accent --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-[#171717] to-[#fd2800]"></div>

                <div class="p-8 md:p-10">
                    <form action="{{ route('pegawai.update', $pegawai->id_pegawai) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-8">
                            
                            {{-- SECTION A: Connected Account (Read Only) --}}
                            <div class="bg-[#fafafa] rounded-2xl p-6 border border-[#ededed] flex items-start gap-5">
                                <div class="hidden sm:flex h-12 w-12 rounded-full bg-[#171717] items-center justify-center text-white shrink-0">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-[#fd2800] mb-1">Akun Terhubung</h3>
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div>
                                            <p class="text-lg font-bold text-[#171717]">{{ $pegawai->user->username ?? 'User Tidak Ditemukan' }}</p>
                                            <p class="text-xs text-[#444444]">User ID: #{{ $pegawai->id_pengguna }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#ededed] text-[#444444] border border-[#d4d4d4]">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Akun Terkunci
                                        </span>
                                    </div>
                                    <p class="text-xs text-[#444444]/60 mt-2 italic">
                                        *Untuk mengubah akun user, silakan hubungi Super Admin atau hapus data pegawai ini dan buat baru.
                                    </p>
                                </div>
                            </div>

                            <hr class="border-[#ededed]">

                            {{-- SECTION B: Personal Information --}}
                            <div>
                                <h3 class="text-lg font-bold text-[#171717] mb-6 flex items-center gap-2">
                                    <span class="w-1.5 h-6 bg-[#fd2800] rounded-full"></span>
                                    Informasi Personal
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- NIP (Read Only) --}}
                                    <div class="group">
                                        <label class="block text-sm font-bold text-[#171717] mb-2">Nomor Induk Pegawai (NIP)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-[#444444]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 1.627-1.016 2.158A4.01 4.01 0 0113 8c1.357 0 2.553.684 3.284 1.737C17.206 8.527 18 7.378 18 6m-5-1" />
                                                </svg>
                                            </div>
                                            <input type="text" 
                                                name="nip_pegawai" 
                                                value="{{ $pegawai->nip_pegawai }}" 
                                                readonly 
                                                class="block w-full pl-10 pr-4 py-3 rounded-xl bg-[#ededed]/50 text-[#444444] font-mono font-medium border-transparent focus:border-transparent focus:ring-0 cursor-not-allowed">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-4 w-4 text-[#444444]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Nama Lengkap --}}
                                    <div>
                                        <label class="block text-sm font-bold text-[#171717] mb-2">Nama Lengkap <span class="text-[#fd2800]">*</span></label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <input type="text" 
                                                name="nama_pegawai" 
                                                value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" 
                                                class="block w-full pl-10 pr-4 py-3 rounded-xl border border-[#ededed] bg-[#fafafa] text-[#171717] placeholder-[#444444]/40 focus:bg-white focus:border-[#fd2800] focus:ring focus:ring-[#fd2800]/20 transition-all shadow-sm">
                                        </div>
                                        @error('nama_pegawai') <p class="text-[#fd2800] text-xs mt-1 font-semibold flex items-center gap-1"><svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION C: Job Details --}}
                            <div>
                                <h3 class="text-lg font-bold text-[#171717] mb-6 flex items-center gap-2">
                                    <span class="w-1.5 h-6 bg-[#fd2800] rounded-full"></span>
                                    Detail Pekerjaan
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Jabatan --}}
                                    <div>
                                        <label class="block text-sm font-bold text-[#171717] mb-2">Jabatan</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input type="text" 
                                                name="jabatan" 
                                                value="{{ old('jabatan', $pegawai->jabatan) }}" 
                                                class="block w-full pl-10 pr-4 py-3 rounded-xl border border-[#ededed] bg-[#fafafa] text-[#171717] placeholder-[#444444]/40 focus:bg-white focus:border-[#fd2800] focus:ring focus:ring-[#fd2800]/20 transition-all shadow-sm">
                                        </div>
                                        @error('jabatan') <p class="text-[#fd2800] text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Bidang Kerja --}}
                                    <div>
                                        <label class="block text-sm font-bold text-[#171717] mb-2">Bidang Kerja / Divisi</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <input type="text" 
                                                name="bidang_kerja" 
                                                value="{{ old('bidang_kerja', $pegawai->bidang_kerja) }}" 
                                                class="block w-full pl-10 pr-4 py-3 rounded-xl border border-[#ededed] bg-[#fafafa] text-[#171717] placeholder-[#444444]/40 focus:bg-white focus:border-[#fd2800] focus:ring focus:ring-[#fd2800]/20 transition-all shadow-sm">
                                        </div>
                                        @error('bidang_kerja') <p class="text-[#fd2800] text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION D: Status --}}
                            <div>
                                <label class="block text-sm font-bold text-[#171717] mb-2">Status Kepegawaian</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <select name="status_pegawai" class="block w-full pl-10 pr-10 py-3 rounded-xl border border-[#ededed] bg-[#fafafa] text-[#171717] focus:bg-white focus:border-[#fd2800] focus:ring focus:ring-[#fd2800]/20 transition-all shadow-sm appearance-none">
                                        <option value="aktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'aktif' ? 'selected' : '' }}>Aktif - Pegawai Siap Bertugas</option>
                                        <option value="nonaktif" {{ old('status_pegawai', $pegawai->status_pegawai) == 'nonaktif' ? 'selected' : '' }}>Non-Aktif - Pegawai Cuti/Berhenti</option>
                                    </select>
                                    {{-- Custom Arrow --}}
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-[#444444]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Footer Action Buttons --}}
                        <div class="mt-10 pt-6 border-t border-[#ededed] flex items-center justify-end gap-4">
                            <a href="{{ route('pegawai.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-[#444444] hover:bg-[#ededed] transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-[#fd2800] hover:bg-[#171717] text-white rounded-xl text-sm font-bold shadow-lg shadow-[#fd2800]/30 hover:shadow-gray-400/50 transition-all duration-300 transform hover:-translate-y-1">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            
            <p class="text-center text-xs text-[#444444]/40 mt-8 font-mono">Secure Form System v2.0</p>
        </div>
    </div>
</x-app-layout>