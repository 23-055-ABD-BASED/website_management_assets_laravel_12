<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\Admin\AsetController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ChatController;

use App\Livewire\ChatSupport;
use App\Livewire\AdminChat;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Aset;
use App\Models\Peminjaman;

use Carbon\Carbon;
use App\Http\Controllers\Admin\DashboardStatistikController;

/*
|--------------------------------------------------------------------------
| ROOT & LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        // Kalau sudah login, arahkan sesuai role
        return (Auth::user()->role === 'admin') 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('dashboard');
    }
    // Kalau belum login, tampilkan landing page biru lo
    return view('welcome');
})->name('landing');

/* Login / Register */
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| AUTH PROCESS (LOGIN/LOGOUT)
|--------------------------------------------------------------------------
*/

// tes
Route::get('/tes-landing', function() {
    return view('welcome');
});

// TAMBAHKAN BARIS INI (Untuk nampilin halaman login)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USER DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $pegawai = Auth::user()->pegawai;

        $riwayatPinjam = $pegawai
            ? Peminjaman::where('id_pegawai', $pegawai->id_pegawai)
                ->with('aset')
                ->latest()
                ->get()
            : [];

        $assets = Aset::where('status_aset', 'tersedia')->get();

        return view('dashboard', compact('riwayatPinjam', 'assets'));
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | CHAT USER (LIVEWIRE)
    |--------------------------------------------------------------------------
    */
    Route::get('/chat-bantuan', ChatSupport::class)
        ->name('chat.index');

    Route::get('/chat/check-new', [ChatController::class, 'checkNewMessages'])
        ->name('chat.check.new');

    /*
    |--------------------------------------------------------------------------
    | PEGAWAI & PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    Route::get('/pegawai/daftar', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');

    Route::middleware('pegawai.aktif')->group(function () {
        Route::post('/peminjaman/ajukan', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');

        Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'indexUser'])
            ->name('peminjaman.index');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA
    |--------------------------------------------------------------------------
    */
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', function (Illuminate\Http\Request $request) {
        
        // 1. DATA TAHUN & FILTER
        $daftarTahun = Peminjaman::selectRaw('YEAR(tanggal_pinjam) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        $tahunAktif = $request->get('tahun', date('Y'));

        // 2. DATA BULAN LENGKAP (Solusi Error $bulanLengkap)
        // Ini akan mengisi angka 0 untuk bulan yang tidak ada datanya agar grafik tidak kosong
        $statsBulanan = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', $tahunAktif)
            ->groupBy('bulan')
            ->get()
            ->keyBy('bulan');

        $bulanLengkap = collect(range(1, 12))->map(function ($bulan) use ($statsBulanan) {
            return (object) [
                'bulan' => $bulan,
                'total' => $statsBulanan->has($bulan) ? $statsBulanan[$bulan]->total : 0
            ];
        });

        // 3. Helper Function untuk Growth
        $getGrowth = function ($model) {
            $now = Carbon::now();
            $currentMonth = $model::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)->count();
            $lastMonth = $model::whereMonth('created_at', $now->copy()->subMonth()->month)
                ->whereYear('created_at', $now->copy()->subMonth()->year)->count();
            $diff = $currentMonth - $lastMonth;
            $percentage = $lastMonth > 0 ? round(($diff / $lastMonth) * 100, 1) : ($currentMonth > 0 ? 100 : 0);

            return [
                'total' => $model::count(),
                'diff' => $diff,
                'percentage' => $percentage,
                'is_positive' => $diff >= 0
            ];
        };

        // 4. Statistik Utama
        $total = [
            'user' => User::count(),
            'pegawai' => Pegawai::count(),
            'aset' => Aset::count(),
            'peminjaman' => Peminjaman::count(),
        ];

        $growth = [
            'user' => $getGrowth(User::class),
            'pegawai' => $getGrowth(Pegawai::class),
            'aset' => $getGrowth(Aset::class),
            'peminjaman' => $getGrowth(Peminjaman::class),
        ];

        $stats = [
            'pegawai' => $growth['pegawai'],
            'user' => $growth['user'],
            'aset' => $growth['aset'],
        ];

        // 5. Data Tambahan untuk Sidebar & Chart
        $topPeminjam = Peminjaman::select('id_pegawai')
            ->selectRaw('COUNT(*) as total')
            ->whereYear('tanggal_pinjam', $tahunAktif)
            ->groupBy('id_pegawai')
            ->with('pegawai')
            ->orderByDesc('total')
            ->limit(5)->get();

        $assetHealth = [
            'tersedia' => Aset::where('status_aset', 'tersedia')->count(),
            'digunakan' => Aset::where('status_aset', 'digunakan')->count(),
            'rusak' => Aset::where('status_aset', 'rusak')->count(),
        ];

        $stokKategori = Aset::select('kategori_aset')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status_aset = "tersedia" THEN 1 ELSE 0 END) as tersedia')
            ->groupBy('kategori_aset')->get();

        $latestPegawai = Pegawai::latest()->take(5)->get();
        
        $peminjamanTerlambat = Peminjaman::with(['pegawai', 'aset'])
            ->where('status', 'disetujui')
            ->whereNull('tanggal_kembali_real')
            ->where('tanggal_kembali', '<', now())->get();

        $users = User::where('role', '!=', 'admin')->doesntHave('pegawai')->get();

        // Data Chart Line (12 Bulan terakhir)
        $peminjamanTrend = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('bulan')->orderBy('bulan')->get();

        // Statistik Persentase
        $rataDurasiPinjam = round(Peminjaman::whereNotNull('tanggal_kembali_real')
            ->selectRaw('AVG(DATEDIFF(tanggal_kembali_real, tanggal_pinjam))')->value('avg')) ?? 0;
        
        $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();
        $tingkatKeterlambatan = $totalDisetujui > 0 ? round(($peminjamanTerlambat->count() / $totalDisetujui) * 100, 1) : 0;

        $pegawaiAktif = Pegawai::where('status_pegawai', 'aktif')->count();
        $pegawaiTidakAktif = Pegawai::where('status_pegawai', 'nonaktif')->count();

        // 6. KIRIM KE VIEW
        return view('admin.dashboard', compact(
            'total', 'growth', 'stats', 'bulanLengkap', 'daftarTahun', 'tahunAktif',
            'topPeminjam', 'assetHealth', 'stokKategori', 'latestPegawai', 
            'peminjamanTerlambat', 'users', 'peminjamanTrend', 'rataDurasiPinjam',
            'tingkatKeterlambatan', 'pegawaiAktif', 'pegawaiTidakAktif'
        ));

    })->name('admin.dashboard');

        /*
        | FITUR LIVE CHAT ADMIN
        */
        
        Route::get('/admin/chat', AdminChat::class)
            ->name('admin.chat.index');

        /*
        | ADMIN PEMINJAMAN
        */
        Route::get('/admin/peminjaman', [PeminjamanController::class, 'indexAdmin'])
            ->name('admin.peminjaman.index');

        Route::patch('/admin/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])
            ->name('admin.peminjaman.approve');

        Route::patch('/admin/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])
            ->name('admin.peminjaman.reject');

        Route::patch('/admin/peminjaman/{id}/return', [PeminjamanController::class, 'returnAsset'])
            ->name('admin.peminjaman.return');

        Route::get('/admin/check-pending', [PeminjamanController::class, 'checkPending'])
            ->name('admin.check.pending');

        /*
        | ADMIN ASET
        */
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('aset', AsetController::class);
        });

        /*
        | ADMIN PEGAWAI
        */
        Route::resource('pegawai', PegawaiController::class)->except(['create', 'store']);
    }); 

    /*
    | CETAK PDF
    */
    Route::get('/admin/peminjaman/cetak-pdf', [PeminjamanController::class, 'cetakPdf'])
        ->name('admin.peminjaman.cetak-pdf');

}); // <-- Tutup Auth Middleware

require __DIR__ . '/auth.php';