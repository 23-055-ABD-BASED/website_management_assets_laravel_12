<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\Admin\AsetController;

/*
|--------------------------------------------------------------------------
| ROOT & LOGIN VIEW
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

// REGISTER VIEW & STORE
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| AUTH (AJAX ONLY)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ADMIN
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        // CRUD ASET (ADMIN)
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('aset', AsetController::class);
        });

    });

    // PEGAWAI (WAJIB DIISI DULU)
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])
        ->name('pegawai.create');

    Route::post('/pegawai', [PegawaiController::class, 'store'])
        ->name('pegawai.store');

    // DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })
    ->middleware('pegawai.exists')
    ->name('dashboard');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
