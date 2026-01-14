<x-app-layout>
    <div class="relative bg-slate-900 pb-32 pt-12">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute left-0 top-0 h-full w-full bg-gradient-to-r from-blue-600 to-indigo-900 opacity-50"></div>
        </div>
        
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-white sm:truncate sm:text-3xl sm:tracking-tight">
                        Selamat Datang, {{ auth()->user()->username ?? 'User' }}
                    </h2>
                    <p class="mt-2 text-sm text-blue-100">
                        Sistem Informasi Manajemen Aset & Kepegawaian
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

    <div class="-mt-24 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-12 relative z-10">
        
        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-50 p-4 border-l-4 border-green-400 shadow-sm animate-fade-in-down">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (!auth()->user()->pegawai)
            <div class="bg-white rounded-xl shadow-xl overflow-hidden text-center py-16 px-6">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                    <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>                  
                </div>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Data Pegawai Belum Lengkap</h3>
                <p class="mt-1 text-gray-500 max-w-sm mx-auto">Anda belum melengkapi data kepegawaian. Silakan isi formulir untuk mengakses fitur lengkap.</p>
                <div class="mt-6">
                    <a href="{{ route('pegawai.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all duration-200">
                        <svg class="-ml-0.5 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        Lengkapi Data Sekarang
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100">
                
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Informasi Kepegawaian</h3>
                        <p class="mt-1 text-sm text-gray-500">Detail data diri yang terdaftar dalam sistem.</p>
                    </div>
                    
                    <span class="inline-flex items-center gap-x-1.5 rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset 
                        {{ auth()->user()->pegawai->status_pegawai === 'aktif' 
                            ? 'bg-green-50 text-green-700 ring-green-600/20' 
                            : 'bg-red-50 text-red-700 ring-red-600/10' }}">
                        <svg class="h-1.5 w-1.5 {{ auth()->user()->pegawai->status_pegawai === 'aktif' ? 'fill-green-500' : 'fill-red-500' }}" viewBox="0 0 6 6" aria-hidden="true">
                            <circle cx="3" cy="3" r="3" />
                        </svg>
                        {{ strtoupper(auth()->user()->pegawai->status_pegawai) }}
                    </span>
                </div>

                <div class="px-6 py-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nomor Induk Pegawai (NIP)</dt>
                            <dd class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                                {{ auth()->user()->pegawai->nip_pegawai }}
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ auth()->user()->pegawai->nama_pegawai }}
                            </dd>
                        </div>

                        <div class="border-t border-gray-100 pt-6 sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Bidang Kerja</dt>
                            <dd class="mt-2 flex items-center text-sm text-gray-900">
                                <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                                {{ auth()->user()->pegawai->bidang_kerja }}
                            </dd>
                        </div>

                        <div class="border-t border-gray-100 pt-6 sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Jabatan Saat Ini</dt>
                            <dd class="mt-2 flex items-center text-sm text-gray-900">
                                <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                </svg>                                  
                                {{ auth()->user()->pegawai->jabatan }}
                            </dd>
                        </div>

                    </dl>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex items-start space-x-3">
                        <svg class="h-5 w-5 text-blue-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Data di atas bersifat <span class="font-semibold text-gray-700">read-only</span> (hanya lihat). 
                            Jika terdapat kesalahan penulisan nama, jabatan, atau NIP, silakan segera hubungi <a href="#" class="text-blue-600 hover:underline">Administrator Sistem</a> untuk pemutakhiran data.
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>