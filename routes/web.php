<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Models\User; 

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
    // Route ini ditaruh DI LUAR middleware 'admin' agar user biasa bisa akses.
    // URL kita buat beda sedikit agar rapi (/pegawai/daftar).
    Route::get('/pegawai/daftar', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');

    // --- 3. PROFILE SETTINGS ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 4. GROUP KHUSUS ADMIN ---
    Route::middleware('admin')->group(function () {
        
        // ADMIN DASHBOARD
        Route::get('/admin/dashboard', function () {
            // Data untuk modal popup (jika masih digunakan admin)
            $users = User::where('role', '!=', 'admin')
                        ->doesntHave('pegawai')
                        ->get();

            return view('admin.dashboard', compact('users'));
        })->name('admin.dashboard');

        // MANAJEMEN PEGAWAI (Admin Only)
        // Kita definisikan manual sisa route resource agar tidak bentrok dengan create/store di atas.
        
        // Melihat Daftar Pegawai
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        
        // Edit & Update Data Pegawai (Biasanya tugas HRD/Admin)
        Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::patch('/pegawai/{pegawai}', [PegawaiController::class, 'update']); // Support PATCH too
        
        // Hapus Pegawai
        Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    });

});