<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\Admin\AsetController;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Aset;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| ROOT & LOGIN VIEW
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        // Cek role user: Admin ke dashboard admin, User biasa ke dashboard user
        if (auth()->user()->role === 'admin') {
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
        return view('dashboard');
    })->name('dashboard');

    // --- 2. PEGAWAI SELF-SERVICE (User Mendaftarkan Diri) ---
    // URL dibuat '/pegawai/daftar' agar user biasa bisa akses form create
    Route::get('/pegawai/daftar', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');

    // --- 3. PROFILE SETTINGS ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 4. GROUP KHUSUS ADMIN ---
    Route::middleware('admin')->group(function () {

        // ==========================================
        // ADMIN DASHBOARD (Logika Statistik Realtime)
        // ==========================================
        Route::get('/admin/dashboard', function () {
            // 1. Helper function hitung pertumbuhan bulan ini vs bulan lalu
            $getGrowth = function ($model) {
                $now = Carbon::now();
                $currentMonth = $model::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
                $lastMonth = $model::whereMonth('created_at', $now->subMonth()->month)->whereYear('created_at', $now->subMonth()->year)->count();
                
                $diff = $currentMonth - $lastMonth;
                // Hindari division by zero
                $percentage = $lastMonth > 0 ? round(($diff / $lastMonth) * 100, 1) : ($currentMonth > 0 ? 100 : 0);
                
                return [
                    'total' => $model::count(),
                    'diff' => $diff,
                    'percentage' => $percentage,
                    'is_positive' => $diff >= 0
                ];
            };

            // 2. Hitung Statistik
            $stats = [
                'pegawai' => $getGrowth(Pegawai::class),
                'user'    => $getGrowth(User::class),
                'aset'    => $getGrowth(Aset::class),
            ];

            // 3. Data Preview Tabel (5 Terakhir)
            $latestPegawai = Pegawai::latest()->take(5)->get();
            $latestAset    = Aset::latest()->take(5)->get();

            // 4. Data User untuk Modal "Tambah Pegawai"
            $users = User::where('role', '!=', 'admin')
                        ->doesntHave('pegawai')
                        ->get();

            return view('admin.dashboard', compact('stats', 'latestPegawai', 'latestAset', 'users'));
        })->name('admin.dashboard');

        // ==========================================
        // MANAJEMEN ASET (Resource)
        // ==========================================
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('aset', AsetController::class);
        });

        // ==========================================
        // MANAJEMEN PEGAWAI (Admin Actions)
        // ==========================================
        // Index Pegawai
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        
        // Edit & Update
        Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::patch('/pegawai/{pegawai}', [PegawaiController::class, 'update']);
        
        // Hapus
        Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    });

});