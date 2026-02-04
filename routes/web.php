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
| ROOT & AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

/* Login / Register */
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

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
    Route::middleware('admin')->group(function () {

        /*
        | ADMIN DASHBOARD (PERBAIKAN LENGKAP - DATA SUDAH ADA SEMUA)
        */
        Route::get('/admin/dashboard', function () {

            // 1. Helper Function untuk Growth
            $getGrowth = function ($model) {
                $now = Carbon::now();
                $currentMonth = $model::whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->count();
                $lastMonth = $model::whereMonth('created_at', $now->copy()->subMonth()->month)
                    ->whereYear('created_at', $now->copy()->subMonth()->year)
                    ->count();
                $diff = $currentMonth - $lastMonth;
                $percentage = $lastMonth > 0
                    ? round(($diff / $lastMonth) * 100, 1)
                    : ($currentMonth > 0 ? 100 : 0);

                return [
                    'total'      => $model::count(),
                    'diff'       => $diff,
                    'percentage' => $percentage,
                    'is_positive' => $diff >= 0
                ];
            };

            // 2. Data Utama (Total & Growth)
            $total = [
                'user'       => User::count(),
                'pegawai'    => Pegawai::count(),
                'aset'       => Aset::count(),
                'peminjaman' => Peminjaman::count(),
            ];

            $growth = [
                'user'       => $getGrowth(User::class),
                'pegawai'    => $getGrowth(Pegawai::class),
                'aset'       => $getGrowth(Aset::class),
                'peminjaman' => $getGrowth(Peminjaman::class),
            ];

            // 3. Stats untuk Card Dashboard
            $stats = [
                'pegawai' => $growth['pegawai'],
                'user'    => $growth['user'],
                'aset'    => $growth['aset'],
                'pending_request' => Peminjaman::where('status', 'pending')->count(),
            ];

            // 4. DATA CHART & TABLE
            $peminjamanBulanan = Peminjaman::selectRaw('MONTH(created_at) as bulan')
                ->selectRaw('COUNT(*) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            $topPeminjam = Peminjaman::select('id_pegawai')
                ->selectRaw('COUNT(*) as total')
                ->whereYear('tanggal_pinjam', now()->year)
                ->whereHas('pegawai', function ($q) {
                    $q->where('status_pegawai', 'aktif');
                })
                ->groupBy('id_pegawai')
                ->with('pegawai')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            $peminjamanTrend = Peminjaman::selectRaw('YEAR(created_at) as tahun')
                ->selectRaw('MONTH(created_at) as bulan')
                ->selectRaw('COUNT(*) as total')
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('tahun', 'bulan')
                ->orderBy('tahun')
                ->orderBy('bulan')
                ->get();

            $assetHealth = [
                'tersedia'  => Aset::where('status_aset', 'tersedia')->count(),
                'digunakan' => Aset::where('status_aset', 'digunakan')->count(),
                'rusak'     => Aset::where('status_aset', 'rusak')->count(),
            ];

            $rataDurasiPinjam = round(
                Peminjaman::whereNotNull('tanggal_kembali_real')
                    ->selectRaw('AVG(DATEDIFF(tanggal_kembali_real, tanggal_pinjam))')
                    ->value('AVG(DATEDIFF(tanggal_kembali_real, tanggal_pinjam))')
            ) ?? 0;

            $pegawaiAktif = Pegawai::where('status_pegawai', 'aktif')->count();
            $pegawaiTidakAktif = Pegawai::where('status_pegawai', 'nonaktif')->count();

            $totalDisetujui = Peminjaman::where('status', 'disetujui')->count();
            $terlambat = Peminjaman::where('status', 'disetujui')
                ->whereColumn('tanggal_kembali_real', '>', 'tanggal_kembali')
                ->count();

            $tingkatKeterlambatan = $totalDisetujui > 0
                ? round(($terlambat / $totalDisetujui) * 100, 1)
                : 0;

            $stokKategori = Aset::select('kategori_aset')
                ->selectRaw('COUNT(*) as total')
                ->selectRaw('SUM(status_aset = "tersedia") as tersedia')
                ->groupBy('kategori_aset')
                ->get();

            // 5. Data List Table
            $latestPegawai = Pegawai::latest()->take(5)->get();
            $latestAset    = Aset::latest()->take(5)->get();
            
            $incomingRequests = Peminjaman::with(['pegawai', 'aset'])
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            $peminjamanTerlambat = Peminjaman::with(['pegawai', 'aset'])
                ->where('status', 'disetujui')
                ->whereNull('tanggal_kembali_real')
                ->where('tanggal_kembali', '<', now())
                ->get();

            $users = User::where('role', '!=', 'admin')
                ->doesntHave('pegawai')
                ->get();

            // Return View dengan data LENGKAP
            return view('admin.dashboard', compact(
                'total', 'growth', 'stats', 
                'peminjamanBulanan', 'topPeminjam', 'peminjamanTrend', 
                'assetHealth', 'rataDurasiPinjam', 
                'pegawaiAktif', 'pegawaiTidakAktif', 'tingkatKeterlambatan',
                'latestPegawai', 'latestAset', 'stokKategori',
                'incomingRequests', 'peminjamanTerlambat', 'users'
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