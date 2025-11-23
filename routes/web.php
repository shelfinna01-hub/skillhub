<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('peserta.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Kelas Management
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [\App\Http\Controllers\KelasController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\KelasController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\KelasController::class, 'store'])->name('store');
        Route::get('/{kelas}', [\App\Http\Controllers\KelasController::class, 'show'])->name('show');
        Route::get('/{kelas}/edit', [\App\Http\Controllers\KelasController::class, 'edit'])->name('edit');
        Route::put('/{kelas}', [\App\Http\Controllers\KelasController::class, 'update'])->name('update');
        Route::delete('/{kelas}', [\App\Http\Controllers\KelasController::class, 'destroy'])->name('destroy');
    });

    // Peserta Management (using UserController)
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{peserta}', [UserController::class, 'show'])->name('show');
        Route::get('/{peserta}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{peserta}', [UserController::class, 'update'])->name('update');
        Route::delete('/{peserta}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Pendaftaran Management
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PendaftaranController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\PendaftaranController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\PendaftaranController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\PendaftaranController::class, 'show'])->name('show');
        Route::delete('/{pendaftaran}', [\App\Http\Controllers\PendaftaranController::class, 'destroy'])->name('destroy');
    });

});


// Peserta
Route::middleware(['auth', 'peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});