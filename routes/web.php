
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

// Rute yang bisa diakses tanpa login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Rute yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('bukus', BukuController::class);
    Route::resource('kategoris', KategoriController::class);

    Route::get('/peminjamans/create', [PeminjamanController::class, 'create'])
        ->name('peminjamans.create');

    Route::post('/peminjamans', [PeminjamanController::class, 'store'])
        ->name('peminjamans.store');

    Route::post('/peminjamans/{peminjaman}/kembalikan', [
        PeminjamanController::class,
        'kembalikan'
    ])->name('peminjamans.kembalikan');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
