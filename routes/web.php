<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataNakesController;
use App\Http\Controllers\CodeStemiController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/data-nakes', [DataNakesController::class, 'index'])->name('data-nakes.index');
Route::get('/code-stemi', [CodeStemiController::class, 'index'])->name('code-stemi.index');
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');

// TAMBAHAN ROUTES UNTUK CRUD DATA NAKES
Route::prefix('data-nakes')->group(function () {
    // Route untuk menampilkan form create (opsional)
    Route::get('/create', [DataNakesController::class, 'create'])->name('data-nakes.create');
    
    // Route untuk menyimpan data baru
    Route::post('/', [DataNakesController::class, 'store'])->name('data-nakes.store');
    
    // Route untuk menampilkan detail data (opsional)
    Route::get('/{id}', [DataNakesController::class, 'show'])->name('data-nakes.show');
    
    // Route untuk menampilkan form edit
    Route::get('/{id}/edit', [DataNakesController::class, 'edit'])->name('data-nakes.edit');
    
    // Route untuk update data
    Route::put('/{id}', [DataNakesController::class, 'update'])->name('data-nakes.update');
    
    // Route untuk menghapus data
    Route::delete('/{id}', [DataNakesController::class, 'destroy'])->name('data-nakes.destroy');
});
