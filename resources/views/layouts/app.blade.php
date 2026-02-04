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

        @if(auth()->check())
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            let lastChatId = null;
            let isFirstLoad = true;

            const chatDot   = document.getElementById('chat-dot');
            const chatSound = new Audio("{{ asset('sounds/chat.mp3') }}");

            function pollMessages() {
                // Jangan munculkan notif kalau sedang di halaman chat
                if (window.location.pathname.includes('/chat')) return;

                axios.get('{{ route("chat.check.new") }}')
                    .then(response => {
                        const data = response.data;

                        if (!data.new_message) {
                            isFirstLoad = false;
                            return;
                        }
                        if (chatDot) chatDot.classList.remove('hidden');

                        if (data.message_id === lastChatId || isFirstLoad) {
                            lastChatId = data.message_id;
                            isFirstLoad = false;
                            return;
                        }

                        lastChatId = data.message_id;
                        isFirstLoad = false;

                        chatSound.currentTime = 0;
                        chatSound.volume = 0.6;
                        chatSound.play().catch(() => {});

                        const initial = data.sender_name
                            ? data.sender_name.substring(0, 1).toUpperCase()
                            : '?';

                        // SweetAlert Toast (WA-like)
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1200,
                            timerProgressBar: true,
                            background: '#ffffff',
                            padding: '0.75rem 1rem',
                            customClass: {
                                popup: 'wa-toast'
                            },
                            html: `
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#fd2800] text-white flex items-center justify-center font-bold">
                                        ${initial}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-bold text-sm text-slate-900">
                                            ${data.sender_name}
                                        </div>
                                        <div class="text-sm text-slate-500 truncate">
                                            ${data.message_text}
                                        </div>
                                    </div>
                                </div>
                            `,
                            didOpen: (toast) => {
                                toast.style.cursor = 'pointer';
                                toast.addEventListener('click', () => {
                                    window.location.href =
                                        "{{ auth()->user()->role === 'admin'
                                            ? route('admin.chat.index')
                                            : route('chat.index') }}";
                                });
                            }
                        });
                    })
                    .catch(err => console.error('Polling error:', err));
            }

            setInterval(pollMessages, 4000);
            pollMessages();
        });
        </script>

        <style>
        /* Animasi & feel WhatsApp */
        .wa-toast {
            border-radius: 14px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,.15) !important;
            animation: wa-slide-in .35s ease-out;
        }

        @keyframes wa-slide-in {
            from {
                transform: translateX(30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        </style>
        @endif


<script>
(function () {
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    if (!localStorage.getItem('user_timezone')) {
        fetch('/set-timezone', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ timezone })
        }).then(() => {
            localStorage.setItem('user_timezone', timezone);
        });
    }
})();
</script>



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