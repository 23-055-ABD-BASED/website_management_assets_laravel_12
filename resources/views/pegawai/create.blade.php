<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="relative bg-[#171717] pb-32 pt-12 shadow-2xl overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute left-0 top-0 h-full w-full bg-gradient-to-br from-[#fd2800] via-[#171717] to-[#171717] opacity-20"></div>
            <div class="absolute right-0 bottom-0 h-64 w-64 bg-[#fd2800] opacity-10 blur-3xl rounded-full translate-y-1/2 translate-x-1/2"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h2 class="text-3xl font-extrabold leading-7 text-white sm:truncate sm:text-4xl sm:tracking-tight tracking-wide flex items-center gap-3">
                        <span class="bg-[#fd2800] w-2 h-8 rounded-sm inline-block shadow-[0_0_10px_#fd2800]"></span>
                        Data Pegawai
                    </h2>
                    <p class="mt-2 text-sm text-[#ededed]/70 ml-5">
                        Lengkapi informasi kepegawaian Anda untuk mengakses fitur sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="-mt-24 mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 pb-12 relative z-10" 
         x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 100)">
        
        <div class="bg-[#ededed] rounded-2xl shadow-2xl overflow-hidden border border-gray-200 relative"
             x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-10"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="h-2 w-full bg-gradient-to-r from-[#fd2800] to-[#171717]"></div>

            <div class="p-8 md:p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-12 w-12 rounded-full bg-[#fd2800]/10 flex items-center justify-center text-[#fd2800]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#171717]">Formulir Data Diri</h3>
                        <p class="text-sm text-gray-500">Mohon isi data dengan benar dan valid.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 border-l-4 border-[#fd2800] bg-red-50 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-[#fd2800]" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-bold text-[#171717]">Terdapat kesalahan input:</p>
                                <ul class="list-disc ml-5 mt-1 text-sm text-[#444444]">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('pegawai.store') }}" class="space-y-6">
                    @csrf

                    <div class="group">
                        <label class="block text-xs font-bold text-[#444444] uppercase tracking-wider mb-2">NIP Pegawai</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#fd2800] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <input type="text" name="nip_pegawai" value="{{ old('nip_pegawai') }}" placeholder="Nomor Induk Pegawai" required
                                class="block w-full rounded-lg border-gray-300 pl-10 focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-3 transition-shadow duration-200 @error('nip_pegawai') border-red-500 @enderror">
                        </div>
                        @error('nip_pegawai') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="group">
                        <label class="block text-xs font-bold text-[#444444] uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#fd2800] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" placeholder="Nama Sesuai KTP" required
                                class="block w-full rounded-lg border-gray-300 pl-10 focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-3 transition-shadow duration-200 @error('nama_pegawai') border-red-500 @enderror">
                        </div>
                        @error('nama_pegawai') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-xs font-bold text-[#444444] uppercase tracking-wider mb-2">Bidang Kerja</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#fd2800] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="text" name="bidang_kerja" value="{{ old('bidang_kerja') }}" placeholder="Ex: IT, Keuangan" required
                                    class="block w-full rounded-lg border-gray-300 pl-10 focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-3 transition-shadow duration-200 @error('bidang_kerja') border-red-500 @enderror">
                            </div>
                            @error('bidang_kerja') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="group">
                            <label class="block text-xs font-bold text-[#444444] uppercase tracking-wider mb-2">Jabatan</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#fd2800] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Ex: Staff, Manager" required
                                    class="block w-full rounded-lg border-gray-300 pl-10 focus:border-[#fd2800] focus:ring-[#fd2800] sm:text-sm py-3 transition-shadow duration-200 @error('jabatan') border-red-500 @enderror">
                            </div>
                            @error('jabatan') <p class="text-[#fd2800] text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row gap-3">
                        <button type="submit" 
                            class="flex-1 w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg shadow-[#fd2800]/20 text-sm font-bold text-white bg-gradient-to-r from-[#fd2800] to-[#d62200] hover:to-[#b91c00] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#fd2800] transition-all transform hover:-translate-y-0.5">
                            Simpan Data Pegawai
                        </button>
                        
                        <a href="{{ route('dashboard') }}" 
                           class="flex-initial w-full sm:w-auto flex justify-center py-3 px-6 border border-gray-300 rounded-lg shadow-sm text-sm font-bold text-[#444444] bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#444444] transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 