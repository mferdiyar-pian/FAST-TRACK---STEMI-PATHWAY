<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataNakesController;
use App\Http\Controllers\CodeStemiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    
    // ==================== DASHBOARD ROUTES ====================
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/date-data', [DashboardController::class, 'getDateData'])->name('dashboard.date-data');
        Route::get('/real-time-stats', [DashboardController::class, 'getRealTimeStats'])->name('dashboard.real-time-stats');
        Route::get('/dashboard-stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.dashboard-stats');
        Route::get('/monthly-stats', [DashboardController::class, 'getMonthlyStats'])->name('dashboard.monthly-stats');
        Route::get('/chart-stats', [DashboardController::class, 'getChartStats'])->name('dashboard.chart-stats');
        Route::get('/get-code-stemi-by-date', [DashboardController::class, 'getCodeStemiByDate'])->name('dashboard.get-code-stemi-by-date');
        Route::get('/stats', [CodeStemiController::class, 'getStats'])->name('dashboard.stats');
        
        // Route untuk debugging
        Route::get('/debug-date/{date}', [DashboardController::class, 'debugDate'])->name('dashboard.debug-date');
    });

    // ==================== DATA NAKES ROUTES ====================
    Route::prefix('data-nakes')->group(function () {
        Route::get('/', [DataNakesController::class, 'index'])->name('data-nakes.index');
        Route::get('/create', [DataNakesController::class, 'create'])->name('data-nakes.create');
        Route::post('/', [DataNakesController::class, 'store'])->name('data-nakes.store');
        Route::get('/{id}', [DataNakesController::class, 'show'])->name('data-nakes.show');
        Route::get('/{id}/edit', [DataNakesController::class, 'edit'])->name('data-nakes.edit');
        Route::put('/{id}', [DataNakesController::class, 'update'])->name('data-nakes.update');
        Route::delete('/{id}', [DataNakesController::class, 'destroy'])->name('data-nakes.destroy');
        Route::get('/export', [DataNakesController::class, 'export'])->name('data-nakes.export');
    });

    // ==================== CODE STEMI ROUTES ====================
    Route::prefix('code-stemi')->group(function () {
        Route::get('/', [CodeStemiController::class, 'index'])->name('code-stemi.index');
        Route::post('/', [CodeStemiController::class, 'store'])->name('code-stemi.store');
        Route::get('/{id}', [CodeStemiController::class, 'show'])->name('code-stemi.show');
        Route::get('/{id}/edit', [CodeStemiController::class, 'edit'])->name('code-stemi.edit');
        Route::put('/{id}', [CodeStemiController::class, 'update'])->name('code-stemi.update');
        Route::delete('/{id}', [CodeStemiController::class, 'destroy'])->name('code-stemi.destroy');
        Route::patch('/{id}/finish', [CodeStemiController::class, 'finish'])->name('code-stemi.finish');
        Route::post('/{id}/checklist', [CodeStemiController::class, 'updateChecklist'])->name('code-stemi.update-checklist');
        
        // Stats route
        Route::get('/stats', [CodeStemiController::class, 'getStats'])->name('code-stemi.stats');
    });

    // ==================== CALENDAR ROUTES ====================
    Route::prefix('calendar')->group(function () {
        Route::get('/create', [CalendarController::class, 'create'])->name('calendar.create');
        Route::get('/month-data', [CalendarController::class, 'getMonthData'])->name('calendar.month-data');
        Route::get('/date-data', [CalendarController::class, 'getDateData'])->name('calendar.date-data');
        Route::get('/date/{date}', [CalendarController::class, 'getDateData'])->name('calendar.date');
        Route::get('/code-stemi-by-date', [CalendarController::class, 'getCodeStemiByDate'])->name('calendar.code-stemi-by-date');
        Route::get('/dashboard-stats', [CalendarController::class, 'getDashboardStats'])->name('calendar.dashboard-stats');
        Route::get('/monthly-stats', [CalendarController::class, 'getMonthlyStats'])->name('calendar.monthly-stats');
        Route::post('/events', [CalendarController::class, 'storeEvent'])->name('calendar.store-event');
        Route::put('/events/{id}', [CalendarController::class, 'updateEvent'])->name('calendar.update-event');
        Route::get('/events/{id}', [CalendarController::class, 'getEvent'])->name('calendar.get-event');
        Route::delete('/events/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
        Route::get('/dashboard', [CalendarController::class, 'dashboard'])->name('calendar.dashboard');
    });

    // ==================== SETTING ROUTES ====================
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/profile', [SettingController::class, 'updateProfile'])->name('profile.update');
        Route::post('/password', [SettingController::class, 'updatePassword'])->name('password.update');
        Route::post('/notifications', [SettingController::class, 'updateNotifications'])->name('notifications.update');
        Route::post('/photo/upload', [SettingController::class, 'uploadPhoto'])->name('photo.upload');
        Route::post('/photo/remove', [SettingController::class, 'removePhoto'])->name('photo.remove');
        Route::post('/account/deactivate', [SettingController::class, 'deactivateAccount'])->name('account.deactivate');
        Route::post('/account/delete', [SettingController::class, 'deleteAccount'])->name('account.delete');
        Route::post('/profile-photo', [SettingController::class, 'updateProfilePhoto'])->name('update-profile-photo');
        Route::post('/remove-profile-photo', [SettingController::class, 'removeProfilePhoto'])->name('remove-profile-photo');
    });

    // ==================== API ROUTES (untuk frontend) ====================
    Route::prefix('api')->group(function () {
        // Calendar API
        Route::prefix('calendar')->group(function () {
            Route::get('/month-data', [CalendarController::class, 'getMonthData']);
            Route::get('/date-data/{date}', [CalendarController::class, 'getDateData']);
            Route::post('/events', [CalendarController::class, 'storeEvent']);
            Route::delete('/events/{id}', [CalendarController::class, 'destroy']);
        });
        
        // Dashboard API
        Route::prefix('dashboard')->group(function () {
            Route::get('/stats', [DashboardController::class, 'getDashboardStats']);
            Route::get('/date-data', [DashboardController::class, 'getDateData']);
            Route::get('/chart-stats', [DashboardController::class, 'getChartStats']);
        });
    });
});