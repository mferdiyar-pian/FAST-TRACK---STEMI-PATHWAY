<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataNakesController;
use App\Http\Controllers\CodeStemiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BroadcastController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/data-nakes', [DataNakesController::class, 'index'])->name('data-nakes.index');

// ROUTES CODE STEMI
Route::prefix('code-stemi')->group(function () {
    // Route utama untuk index
    Route::get('/', [CodeStemiController::class, 'index'])->name('code-stemi.index');
    
    // Route untuk menyimpan data baru (aktivasi code stemi)
    Route::post('/', [CodeStemiController::class, 'store'])->name('code-stemi.store');
    
    // Route untuk menampilkan detail (modal detail)
    Route::get('/{id}', [CodeStemiController::class, 'show'])->name('code-stemi.show');
    
    // Route untuk menampilkan form edit (modal edit)
    Route::get('/{id}/edit', [CodeStemiController::class, 'edit'])->name('code-stemi.edit');
    
    // Route untuk update data (proses edit)
    Route::put('/{id}', [CodeStemiController::class, 'update'])->name('code-stemi.update');
    
    // Route untuk menghapus data
    Route::delete('/{id}', [CodeStemiController::class, 'destroy'])->name('code-stemi.destroy');
    
    // Route tambahan untuk finish code stemi
    Route::patch('/{id}/finish', [CodeStemiController::class, 'finish'])->name('code-stemi.finish');
    
    // Route untuk update checklist (jika masih digunakan)
    Route::post('/{id}/checklist', [CodeStemiController::class, 'updateChecklist'])->name('code-stemi.update-checklist');
});

// ROUTES SETTING
Route::prefix('setting')->group(function () {
    // Route utama untuk menampilkan halaman setting
    Route::get('/', [SettingController::class, 'index'])->name('setting.index');
    
    // Route untuk update profile information
    Route::post('/profile', [SettingController::class, 'updateProfile'])->name('setting.profile.update');
    
    // Route untuk update password
    Route::post('/password', [SettingController::class, 'updatePassword'])->name('setting.password.update');
    
    // Route untuk update notification settings
    Route::post('/notifications', [SettingController::class, 'updateNotifications'])->name('setting.notifications.update');
    
    // Route untuk upload profile picture
    Route::post('/photo/upload', [SettingController::class, 'uploadPhoto'])->name('setting.photo.upload');
    
    // Route untuk remove profile picture
    Route::post('/photo/remove', [SettingController::class, 'removePhoto'])->name('setting.photo.remove');
    
    // Route untuk deactivate account
    Route::post('/account/deactivate', [SettingController::class, 'deactivateAccount'])->name('setting.account.deactivate');
    
    // Route untuk delete account
    Route::post('/account/delete', [SettingController::class, 'deleteAccount'])->name('setting.account.delete');
});

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

