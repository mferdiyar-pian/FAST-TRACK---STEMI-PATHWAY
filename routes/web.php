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
