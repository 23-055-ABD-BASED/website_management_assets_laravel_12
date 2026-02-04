<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASETU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#fd2800',
                        dark: '#171717',
                        light: '#ededed',
                        grayCustom: '#444444',
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ededed;
        }

        .glass-nav {
            background: rgba(237, 237, 237, 0.8);
            backdrop-filter: blur(12px);
        }

        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(253, 50, 0, 0.10), transparent);
        }

        .btn-primary {
            background-color: #fd2800;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #171717;
            transform: translateY(-2px);
        }

        .card-hover:hover {
            border-color: #fd2800;
            transform: translateY(-5px);
        }

        /* ===== MOBILE MENU ===== */
        #mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(23, 23, 23, 0.45);
            backdrop-filter: blur(12px);
            isolation: isolate;
        }
        #mobile-menu.active {
            transform: translateX(0);
        }

        #mobile-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
            background: rgba(0, 0, 0, 0.55);
        }
        #mobile-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>

<body class="text-dark overflow-x-hidden">

<!-- ================= NAVBAR ================= -->
<nav class="fixed top-0 left-0 right-0 z-50 glass-nav border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo_asetu.png') }}" alt="Logo" class="h-10 w-auto">
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-bold uppercase tracking-widest">
                <a href="#fitur" class="hover:text-primary transition">Fitur</a>
                <a href="#tentang" class="hover:text-primary transition">Tentang</a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-3 text-white rounded-full">Dashboard</a>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="hover:text-primary transition">Masuk</a>
                            <a href="{{ route('register') }}" class="btn-primary px-6 py-3 text-white rounded-full shadow-lg shadow-primary/20">Registrasi</a>
                        </div>
                    @endauth
                @endif
            </div>

            <button id="mobile-menu-button" class="md:hidden p-2 z-[60]">
                <i id="hamburger-icon" class="fas fa-bars text-2xl transition-all"></i>
            </button>

        </div>
    </div>
</nav>

<!-- ================= MOBILE OVERLAY ================= -->
<div id="mobile-overlay" class="fixed inset-0 z-40 md:hidden"></div>

<!-- ================= MOBILE MENU ================= -->
<div id="mobile-menu"
     class="fixed top-20 right-0 bottom-0 w-[80%] max-w-sm z-50 shadow-2xl md:hidden">

    <div class="flex flex-col h-full p-8">
        <div class="space-y-6 text-right font-bold uppercase tracking-widest text-lg text-white">
            <a href="#fitur" class="mobile-link block py-2 hover:text-primary">Fitur</a>
            <a href="#tentang" class="mobile-link block py-2 hover:text-primary">Tentang</a>

            <hr class="border-white/10 my-6">

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="mobile-link block btn-primary py-4 rounded-xl text-center">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="mobile-link block py-2 hover:text-primary">Masuk</a>
                    <a href="{{ route('register') }}" class="mobile-link block btn-primary py-4 rounded-xl text-center shadow-lg shadow-primary/20">Registrasi</a>
                @endif
            @endif
        </div>

        <div class="mt-auto pb-8 text-center">
            <p class="text-gray-400 text-xs uppercase tracking-widest mb-4">ASETU Inventory 2.0</p>
            <div class="flex justify-center gap-6 text-white/50">
                <i class="fab fa-linkedin"></i>
                <i class="fab fa-github"></i>
                <i class="fab fa-instagram"></i>
            </div>
        </div>
    </div>
</div>

    <section class="relative pt-40 pb-24 hero-gradient overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col items-center text-center">
                <span class="inline-block px-4 py-2 bg-primary/10 text-primary text-xs font-bold rounded-full mb-6 uppercase tracking-widest">
                    Asetu Inventory Management 2.0
                </span>
                <h1 class="text-6xl lg:text-8xl font-black text-dark mb-8 tracking-tighter leading-none">
                    Transformasi <span class="text-primary italic">Aset</span> <br> Secara Digital.
                </h1>
                <p class="max-w-3xl mx-auto text-xl text-grayCustom mb-12 leading-relaxed font-medium">
                    Asetu merupakan platform infrastruktur manajemen inventaris terpadu yang dirancang untuk mengoptimalkan siklus hidup aset perusahaan. Mulai dari pemantauan stok secara real-time hingga otomasi pelaporan, kami menghadirkan presisi dalam setiap manajemen operasional Anda.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="{{ route('login') }}" class="btn-primary px-10 py-5 text-white font-extrabold rounded-2xl shadow-2xl shadow-primary/30 flex items-center justify-center gap-3">
                        Mulai Implementasi <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#fitur" class="px-10 py-5 bg-white text-dark font-extrabold rounded-2xl border-2 border-dark/5 hover:border-primary transition flex items-center justify-center gap-2">
                        Eksplorasi Fitur
                    </a>
                </div>
            </div>
        </div>
        
        <div class="absolute top-0 right-0 -mr-20 w-96 h-96 bg-primary/5 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 -ml-20 w-80 h-80 bg-dark/5 rounded-full blur-[100px]"></div>
    </section>

    <section id="fitur" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-20">
                <h2 class="text-4xl font-black tracking-tighter text-dark mb-4">Ekosistem Pengelolaan</h2>
                <div class="h-1.5 w-24 bg-primary rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-10 rounded-3xl bg-light border border-transparent card-hover transition duration-300">
                    <div class="w-14 h-14 bg-dark text-primary rounded-2xl flex items-center justify-center mb-8">
                        <i class="fas fa-database text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-4">Manajemen Aset</h3>
                    <p class="text-grayCustom font-medium leading-relaxed">Pusat kendali inventaris untuk pendaftaran, kategorisasi, dan pemantauan kondisi aset fisik perusahaan secara detail dan terstruktur.</p>
                </div>

                <div class="p-10 rounded-3xl bg-light border border-transparent card-hover transition duration-300">
                    <div class="w-14 h-14 bg-dark text-primary rounded-2xl flex items-center justify-center mb-8">
                        <i class="fas fa-exchange-alt text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-4">Peminjaman Aset</h3>
                    <p class="text-grayCustom font-medium leading-relaxed">Sistem sirkulasi aset yang transparan dengan alur persetujuan digital, memastikan setiap perpindahan barang tercatat secara akurat.</p>
                </div>

                <div class="p-10 rounded-3xl bg-light border border-transparent card-hover transition duration-300">
                    <div class="w-14 h-14 bg-dark text-primary rounded-2xl flex items-center justify-center mb-8">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-4">Laporan & Statistik</h3>
                    <p class="text-grayCustom font-medium leading-relaxed">Analisis mendalam mengenai tren peminjaman dan utilisasi aset melalui dashboard statistik yang informatif dan real-time.</p>
                </div>

                <div class="p-10 rounded-3xl bg-light border border-transparent card-hover transition duration-300">
                    <div class="w-14 h-14 bg-dark text-primary rounded-2xl flex items-center justify-center mb-8">
                        <i class="fas fa-print text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-4">Cetak Laporan</h3>
                    <p class="text-grayCustom font-medium leading-relaxed">Eksportasi data legal formal dalam format PDF untuk kebutuhan audit, dokumentasi arsip, dan laporan pertanggungjawaban berkala.</p>
                </div>

                <div class="p-10 rounded-3xl bg-light border border-transparent card-hover transition duration-300 md:col-span-2">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="w-14 h-14 bg-dark text-primary rounded-2xl flex items-center justify-center shrink-0">
                            <i class="fas fa-comments text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold mb-4">Integrated Admin Chat System</h3>
                            <p class="text-grayCustom font-medium leading-relaxed">Saluran komunikasi langsung antara pengguna dan administrator. Mempercepat proses koordinasi teknis, penyelesaian kendala operasional, dan konsultasi ketersediaan aset tanpa hambatan eksternal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-20 bg-dark text-light">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-10">
                
                <div class="flex items-center">
                    <span class="text-2xl font-bold tracking-tight text-white">
                        ASE<span class="text-primary">TU</span>
                    </span>
                </div>
                
                <div class="text-center md:text-right">
                    <p class="text-gray-400 font-bold mb-2 uppercase tracking-widest text-xs">Developed By</p>
                    <p class="text-xl font-black text-white italic">Trunojoyo Maha Asiq Indehoy Team</p>
                    <p class="text-sm text-gray-500 mt-2 font-medium">© 2026 Asetu Trunojoyo. Seluruh hak cipta dilindungi undang-undang.</p>
                </div>
            </div>

            <div class="mt-16 pt-8 border-t border-white/5 text-center">
                <div class="flex justify-center gap-6 text-gray-400">
                    <a href="#" class="hover:text-primary transition"><i class="fab fa-linkedin text-xl"></i></a>
                    <a href="https://github.com/mayWart/website_management_assets_laravel_12.git" target="_blank" class="hover:text-primary transition"><i class="fab fa-github text-xl"></i></a>
                    <a href="#" class="hover:text-primary transition"><i class="fab fa-instagram text-xl"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-overlay');
    const icon = document.getElementById('hamburger-icon');
    const links = document.querySelectorAll('.mobile-link');

    function toggleMenu() {
        menu.classList.toggle('active');
        overlay.classList.toggle('active');

        if (menu.classList.contains('active')) {
            icon.classList.replace('fa-bars', 'fa-times');
            icon.classList.add('text-white');
            document.body.style.overflow = 'hidden';
        } else {
            icon.classList.replace('fa-times', 'fa-bars');
            icon.classList.remove('text-white');
            document.body.style.overflow = 'auto';
        }
    }

    btn.addEventListener('click', toggleMenu);
    overlay.addEventListener('click', toggleMenu);
    links.forEach(link => link.addEventListener('click', toggleMenu));
</script>
</html>