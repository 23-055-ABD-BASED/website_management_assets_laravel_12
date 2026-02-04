<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Aset - Inventaris Kantor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .glass-effect { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="fixed w-full z-50 glass-effect bg-white/70 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <i class="fas fa-boxes text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-800">ASSET<span class="text-blue-600">PRO</span></span>
                </div>
                <div>
                    @if (Route::has('login'))
                        <div>
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                                    Mulai Sekarang
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 mb-6 tracking-tight">
                    Kelola Aset Kantor <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Lebih Cerdas & Cepat.</span>
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-slate-600 mb-10">
                    Sistem inventaris modern untuk melacak, meminjam, dan mengelola aset perusahaan dalam satu platform terpusat.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-xl shadow-blue-200 flex items-center justify-center gap-2">
                        <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
                    </a>
                    <a href="#fitur" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition flex items-center justify-center gap-2">
                        Lihat Fitur
                    </a>
                </div>
            </div>
        </div>
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 opacity-30">
            <div class="absolute top-24 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute top-24 right-10 w-72 h-72 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition group">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-search-plus text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pelacakan Real-time</h3>
                    <p class="text-slate-600">Pantau keberadaan dan status aset Anda secara instan kapan saja dan di mana saja.</p>
                </div>
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition group">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i class="fas fa-hand-holding-heart text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Peminjaman Mudah</h3>
                    <p class="text-slate-600">Proses pengajuan pinjaman aset yang simpel untuk staf melalui dashboard mandiri.</p>
                </div>
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:shadow-xl transition group">
                    <div class="w-12 h-12 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center mb-6 group-hover:bg-cyan-600 group-hover:text-white transition">
                        <i class="fas fa-file-invoice text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Laporan Otomatis</h3>
                    <p class="text-slate-600">Generate laporan aset dan riwayat peminjaman dalam format PDF hanya dengan satu klik.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-400">© 2024 AssetPro Inventaris. Built with ❤️ for better management.</p>
        </div>
    </footer>

</body>
</html>