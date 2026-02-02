<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- ======================================================= --}}
        {{-- 1. SCRIPT KHUSUS ADMIN (NOTIFIKASI REALTIME)            --}}
        {{-- ======================================================= --}}
        @if(auth()->check() && auth()->user()->role === 'admin')
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> 
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let lastCount = 0; 
                    let isFirstLoad = true; 

                    function checkNewRequests() {
                        axios.get('{{ route("admin.check.pending") }}')
                            .then(function (response) {
                                let currentCount = response.data.count;
                                
                                // Update Badge Menu
                                let badge = document.getElementById('pending-badge');
                                if(badge) {
                                    badge.innerText = currentCount;
                                    badge.style.display = currentCount > 0 ? 'inline-flex' : 'none';
                                }

                                // Trigger Notifikasi Suara & Popup
                                if (currentCount > lastCount && !isFirstLoad) {
                                    let audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
                                    audio.play().catch(e => console.log('Audio play blocked'));

                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Permintaan Baru!',
                                        text: 'Ada ' + (currentCount - lastCount) + ' pengajuan aset baru masuk.',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 5000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('click', () => {
                                                window.location.href = "{{ route('admin.peminjaman.index') }}";
                                            });
                                        }
                                    });
                                }

                                lastCount = currentCount;
                                isFirstLoad = false;
                            })
                            .catch(function (error) {
                                console.log('Polling error:', error);
                            });
                    }

                    // Jalankan pertama kali & set interval 5 detik
                    checkNewRequests();
                    setInterval(checkNewRequests, 5000);
                });
            </script>
        @endif

        {{-- ======================================================= --}}
        {{-- 2. SCRIPT SWEETALERT (FLASH MESSAGES)                   --}}
        {{-- ======================================================= --}}

        {{-- Alert: Pegawai Nonaktif --}}
        @if(session('pegawai_nonaktif'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Akses Ditolak',
                        text: @json(session('pegawai_nonaktif')),
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#fd2800',
                        allowOutsideClick: false,
                    });
                });
            </script>
        @endif

        {{-- Alert: Error Kode Aset Duplikat --}}
        @if($errors->has('kode_aset'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kode Aset Duplikat',
                        text: @json($errors->first('kode_aset')),
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#dc2626'
                    });
                });
            </script>
        @endif

        {{-- Alert: Peminjaman Ditolak (Pending) --}}
        @if(session('peminjaman_pending'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peminjaman Ditolak',
                        text: '{{ session('peminjaman_pending') }}',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#fd2800',
                        allowOutsideClick: false
                    });
                });
            </script>
        @endif

        {{-- ======================================================= --}}
        {{-- 3. LIVEWIRE CONFIG (MANUAL BUNDLING)                    --}}
        {{-- ======================================================= --}}
        @livewireScriptConfig

        {{-- ======================================================= --}}
        {{-- 4. PAGE SPECIFIC SCRIPTS (Chart.js, Dashboard, dll)     --}}
        {{-- ======================================================= --}}
        @stack('scripts')
    </body>
</html>