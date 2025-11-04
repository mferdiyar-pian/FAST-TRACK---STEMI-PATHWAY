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

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/date-data', [DashboardController::class, 'getDateData'])->name('dashboard.date-data');
    Route::get('/real-time-stats', [DashboardController::class, 'getRealTimeStats'])->name('dashboard.real-time-stats');
    Route::get('/dashboard-stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.dashboard-stats');
    Route::get('/monthly-stats', [DashboardController::class, 'getMonthlyStats'])->name('dashboard.monthly-stats');
    Route::get('/chart-stats', [DashboardController::class, 'getChartStats'])->name('dashboard.chart-stats');
    Route::get('/get-code-stemi-by-date', [DashboardController::class, 'getCodeStemiByDate'])->name('dashboard.get-code-stemi-by-date');
    Route::get('/stats', [CodeStemiController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/debug-date/{date}', [DashboardController::class, 'debugDate'])->name('dashboard.debug-date');
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    /*
    |--------------------------------------------------------------------------
    | DATA NAKES ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('data-nakes')->group(function () {
        Route::get('/', [DataNakesController::class, 'index'])->name('data-nakes.index');
        Route::get('/create', [DataNakesController::class, 'create'])->name('data-nakes.create');
        Route::get('/export', [DataNakesController::class, 'export'])->name('data-nakes.export'); // ✅ Export Excel
        Route::post('/', [DataNakesController::class, 'store'])->name('data-nakes.store');
        Route::get('/{id}', [DataNakesController::class, 'show'])->name('data-nakes.show');
        Route::get('/{id}/edit', [DataNakesController::class, 'edit'])->name('data-nakes.edit');
        Route::put('/{id}', [DataNakesController::class, 'update'])->name('data-nakes.update');
        Route::delete('/{id}', [DataNakesController::class, 'destroy'])->name('data-nakes.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | CODE STEMI ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('code-stemi')->group(function () {
        Route::get('/', [CodeStemiController::class, 'index'])->name('code-stemi.index');
        Route::post('/', [CodeStemiController::class, 'store'])->name('code-stemi.store');
        Route::get('/export', [CodeStemiController::class, 'export'])->name('code-stemi.export'); // ✅ Export Excel
        Route::get('/{id}', [CodeStemiController::class, 'show'])->name('code-stemi.show');
        Route::get('/{id}/edit', [CodeStemiController::class, 'edit'])->name('code-stemi.edit');
        Route::put('/{id}', [CodeStemiController::class, 'update'])->name('code-stemi.update');
        Route::delete('/{id}', [CodeStemiController::class, 'destroy'])->name('code-stemi.destroy');
        Route::patch('/{id}/finish', [CodeStemiController::class, 'finish'])->name('code-stemi.finish');
        Route::post('/{id}/checklist', [CodeStemiController::class, 'updateChecklist'])->name('code-stemi.update-checklist');
    });

    /*
    |--------------------------------------------------------------------------
    | SETTING ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/profile', [SettingController::class, 'updateProfile'])->name('setting.profile.update');
        Route::post('/password', [SettingController::class, 'updatePassword'])->name('setting.password.update');
        Route::post('/notifications', [SettingController::class, 'updateNotifications'])->name('setting.notifications.update');
        Route::post('/photo/upload', [SettingController::class, 'uploadPhoto'])->name('setting.photo.upload');
        Route::post('/photo/remove', [SettingController::class, 'removePhoto'])->name('setting.photo.remove');
        Route::post('/account/deactivate', [SettingController::class, 'deactivateAccount'])->name('setting.account.deactivate');
        Route::post('/account/delete', [SettingController::class, 'deleteAccount'])->name('setting.account.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | CALENDAR ROUTES
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/stats', [CodeStemiController::class, 'getStats']);
    Route::get('/dashboard', [CalendarController::class, 'dashboard'])->name('dashboard.index');

    Route::prefix('api/calendar')->group(function () {
        Route::get('/month-data', [CalendarController::class, 'getMonthData']);
        Route::get('/date-data/{date}', [CalendarController::class, 'getDateData']);
        Route::post('/events', [CalendarController::class, 'storeEvent']);
        Route::delete('/events/{id}', [CalendarController::class, 'destroy']);
    });

    Route::get('/calendar/create', [CalendarController::class, 'create'])->name('calendar.create');
    Route::get('/calendar/date/{date}', [CalendarController::class, 'getDateData'])->name('calendar.date');
    Route::get('/calendar/dashboard', [CalendarController::class, 'dashboard'])->name('dashboard.index');
    Route::get('/calendar/month-data', [CalendarController::class, 'getMonthData']);
    Route::get('/calendar/date-data', [CalendarController::class, 'getDateData']);
    Route::post('/calendar/events', [CalendarController::class, 'storeEvent']);
    Route::delete('/calendar/events/{id}', [CalendarController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| DUPLICATE SETTING ROUTES (for backward compatibility)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('settings')->name('setting.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('/profile', [SettingController::class, 'updateProfile'])->name('update-profile');
    Route::post('/password', [SettingController::class, 'updatePassword'])->name('update-password');
    Route::post('/notifications', [SettingController::class, 'updateNotifications'])->name('update-notifications');
    Route::post('/profile-photo', [SettingController::class, 'updateProfilePhoto'])->name('update-profile-photo');
    Route::post('/remove-profile-photo', [SettingController::class, 'removeProfilePhoto'])->name('remove-profile-photo');
});
