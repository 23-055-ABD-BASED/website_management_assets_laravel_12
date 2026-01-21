<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @if(auth()->check() && auth()->user()->role === 'admin')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <script>
        document.addEventListener('DOMContentLoaded', function () {
            let lastCount = 0; // Menyimpan jumlah terakhir
            let isFirstLoad = true; // Agar tidak bunyi saat pertama kali buka halaman

            // Fungsi untuk mengecek ke server
            function checkNewRequests() {
                axios.get('{{ route("admin.check.pending") }}')
                    .then(function (response) {
                        let currentCount = response.data.count;
                        
                        // Update angka di Badge Menu (jika ada elemen dengan ID 'pending-badge')
                        let badge = document.getElementById('pending-badge');
                        if(badge) {
                            badge.innerText = currentCount;
                            // Sembunyikan jika 0
                            badge.style.display = currentCount > 0 ? 'inline-flex' : 'none';
                        }

                        // Logika Notifikasi
                        if (currentCount > lastCount && !isFirstLoad) {
                            // Mainkan Suara 'Ting'
                            let audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
                            audio.play().catch(e => console.log('Audio play blocked'));

                            // Munculkan Popup Pojok Kanan Atas
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

            // Jalankan pengecekan pertama kali
            checkNewRequests();

            // Jalankan pengecekan setiap 5 detik (5000 ms)
            setInterval(checkNewRequests, 5000);
        });
    </script>
    @endif

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SWEETALERT: PEGAWAI NONAKTIF --}}
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


</body>
</html>
