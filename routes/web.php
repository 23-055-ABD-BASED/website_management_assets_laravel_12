<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\Admin\AsetController;
use App\Http\Controllers\PeminjamanController;
use App\Livewire\ChatSupport;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Aset;
use App\Models\Peminjaman;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| ROOT & LOGIN VIEW
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

// REGISTER VIEW & STORE (Guest)
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| AUTH PROCESS (LOGIN/LOGOUT)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Harus Login Dulu)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- 1. DASHBOARD USER BIASA ---
Route::get('/dashboard', function () {
    $pegawai = Auth::user()->pegawai;

    $riwayatPinjam = [];
    if ($pegawai) {
        $riwayatPinjam = Peminjaman::where('id_pegawai', $pegawai->id_pegawai)
            ->with('aset')
            ->latest()
            ->get();
    }

    $assets = Aset::where('status_aset', 'tersedia')->get();

    return view('dashboard', compact('riwayatPinjam', 'assets'));
})->name('dashboard');

    // --- 2. PEGAWAI SELF-SERVICE ---
    Route::get('/pegawai/daftar', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');

    // --- 3. PROFILE SETTINGS ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ==========================================
    //  FITUR CHAT BANTUAN (User)
    // ==========================================
    Route::get('/chat-bantuan', ChatSupport::class)
        ->middleware('auth')
        ->name('chat.support');

    


    // ==========================================
    //  FITUR PEMINJAMAN (USER / PEGAWAI)
    // ==========================================
    Route::middleware('pegawai.aktif')->group(function () {

        Route::post('/peminjaman/ajukan', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');

        Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'indexUser'])
            ->name('peminjaman.index');

    });


// --- 4. GROUP KHUSUS ADMIN ---
    Route::middleware('admin')->group(function () {

        // ==========================================
        // ADMIN DASHBOARD
        // ==========================================
Route::get('/admin/dashboard', function () {
    // 1. Helper function hitung pertumbuhan
    $getGrowth = function ($model) {
        $now = Carbon::now();
        $currentMonth = $model::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
        $lastMonth = $model::whereMonth('created_at', $now->subMonth()->month)->whereYear('created_at', $now->subMonth()->year)->count();
        
        $diff = $currentMonth - $lastMonth;
        $percentage = $lastMonth > 0 ? round(($diff / $lastMonth) * 100, 1) : ($currentMonth > 0 ? 100 : 0);
        
        return [
            'total' => $model::count(),
            'diff' => $diff,
            'percentage' => $percentage,
            'is_positive' => $diff >= 0
        ];
    };

    // 2. Hitung Statistik (Box Atas)
    $stats = [
        'pegawai' => $getGrowth(Pegawai::class),
        'user'    => $getGrowth(User::class),
        'aset'    => $getGrowth(Aset::class),
        'pending_request' => Peminjaman::where('status', 'pending')->count() 
    ];

    // 3. Ambil Data Tabel Preview
    $latestPegawai = Pegawai::latest()->take(5)->get();
    $latestAset    = Aset::latest()->take(5)->get();

    // 4. Statistik Stok Per Kategori (Untuk Area Kosong)
    $stokKategori = Aset::select('kategori_aset')
        ->selectRaw('count(*) as total')
        ->selectRaw('sum(case when status_aset = "tersedia" then 1 else 0 end) as tersedia')
        ->groupBy('kategori_aset')
        ->get();

    // 5. Data Peminjaman Terlambat
    $today = Carbon::now()->format('Y-m-d');
    $peminjamanTerlambat = Peminjaman::with(['pegawai', 'aset'])
        ->where('status', 'disetujui')
        ->whereNull('tanggal_kembali_real')
        ->where('tanggal_kembali', '<', $today)
        ->latest()
        ->get();

    // 6. Request Peminjaman Baru (Pending)
    $incomingRequests = Peminjaman::with(['pegawai', 'aset'])
        ->where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();

    // 7. Data User untuk Modal
    $users = User::where('role', '!=', 'admin')
        ->doesntHave('pegawai')
        ->get();

    // 8. RETURN HANYA SATU KALI DI PALING BAWAH
    return view('admin.dashboard', compact(
        'stats', 
        'latestPegawai', 
        'latestAset', 
        'users', 
        'incomingRequests', 
        'peminjamanTerlambat', 
        'stokKategori'
    ));
})->name('admin.dashboard');
        // ==========================================
        //  FITUR LIVE CHAT ADMIN (Letakkan Disini)
        // ==========================================
        Route::get('/admin/chat', function () {
            return view('admin.chat');
        })->name('admin.chat.index');

        // ==========================================
        // MANAJEMEN ASET
        // ==========================================
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('aset', AsetController::class);
        });

        // ==========================================
        // MANAJEMEN PEGAWAI
        // ==========================================
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::patch('/pegawai/{pegawai}', [PegawaiController::class, 'update']);
        Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

        // ==========================================
        // APPROVAL & RETURN PEMINJAMAN (ADMIN)
        // ==========================================
        
        // Halaman Index (Tabulasi)
        Route::get('/admin/peminjaman', [PeminjamanController::class, 'indexAdmin'])->name('admin.peminjaman.index');
        
        // Proses Pengembalian (Return)
        Route::patch('/admin/peminjaman/{id}/return', [PeminjamanController::class, 'returnAsset'])->name('admin.peminjaman.return');

        // Proses Approve & Reject
        Route::patch('/admin/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('admin.peminjaman.approve');
        Route::patch('/admin/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('admin.peminjaman.reject');
        
        // Polling Notifikasi (AJAX)
        Route::get('/admin/check-pending', [PeminjamanController::class, 'checkPending'])->name('admin.check.pending');
    });

    // cetak PDF
    Route::get('/admin/peminjaman/cetak-pdf', [PeminjamanController::class, 'cetakPdf'])->name('admin.peminjaman.cetak-pdf');


});

require __DIR__.'/auth.php';