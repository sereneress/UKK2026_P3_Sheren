<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

// GURU
use App\Http\Controllers\Guru\AspirasiController as GuruAspirasiController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;

// SISWA
use App\Http\Controllers\Siswa\AspirasiController as SiswaAspirasiController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

// PETUGAS
use App\Http\Controllers\Petugas\AspirasiController as PetugasAspirasiController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'guru'    => redirect()->route('guru.dashboard'),
            'siswa'   => redirect()->route('siswa.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'), // ✅ tambahan
            default   => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
})->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // USERS
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/guru', [DashboardController::class, 'guru'])->name('guru');
            Route::get('/siswa', [DashboardController::class, 'siswa'])->name('siswa');
            Route::get('/petugas', [DashboardController::class, 'petugas'])->name('petugas'); // ✅ tambahan
        });

        // CRUD GURU
        Route::post('/guru/store', [DashboardController::class, 'storeGuru'])->name('guru.store');
        Route::put('/guru/{id}', [DashboardController::class, 'updateGuru'])->name('guru.update');
        Route::delete('/guru/{id}', [DashboardController::class, 'destroyGuru'])->name('guru.destroy');

        // CRUD SISWA
        Route::post('/siswa/store', [DashboardController::class, 'storeSiswa'])->name('siswa.store');
        Route::put('/siswa/{id}', [DashboardController::class, 'updateSiswa'])->name('siswa.update');
        Route::delete('/siswa/{id}', [DashboardController::class, 'destroySiswa'])->name('siswa.destroy');

        // CRUD PETUGAS ✅ tambahan
        Route::post('/petugas/store', [DashboardController::class, 'storePetugas'])->name('petugas.store');
        Route::put('/petugas/{id}', [DashboardController::class, 'updatePetugas'])->name('petugas.update');
        Route::delete('/petugas/{id}', [DashboardController::class, 'destroyPetugas'])->name('petugas.destroy');

        // KATEGORI
        Route::get('/kategori', [DashboardController::class, 'kategori'])->name('kategori');

        // PENGADUAN
        Route::get('/pengaduan', [DashboardController::class, 'pengaduan'])->name('pengaduan');
        Route::delete('/pengaduan/{id}', [DashboardController::class, 'destroyAspirasi'])->name('pengaduan.destroy');
    });


/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

        Route::get('/aspirasi', [GuruAspirasiController::class, 'index'])->name('aspirasi.index');
        Route::get('/aspirasi/{id}', [GuruAspirasiController::class, 'detail'])->name('aspirasi.detail');

        Route::post('/aspirasi/{id}/feedback', [GuruAspirasiController::class, 'storeFeedback'])->name('aspirasi.feedback');
        Route::post('/aspirasi/{id}/progres', [GuruAspirasiController::class, 'storeProgres'])->name('aspirasi.progres');

        Route::delete('/aspirasi/{id}', [GuruAspirasiController::class, 'destroy'])->name('aspirasi.destroy');

        Route::get('/history', [GuruAspirasiController::class, 'history'])->name('history');
    });


/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        // ✅ pakai DashboardController (admin)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // tetap pakai controller petugas untuk aspirasi
        Route::get('/aspirasi', [PetugasAspirasiController::class, 'index'])->name('aspirasi.index');
        Route::get('/aspirasi/{id}', [PetugasAspirasiController::class, 'detail'])->name('aspirasi.detail');

        Route::post('/aspirasi/{id}/feedback', [PetugasAspirasiController::class, 'storeFeedback'])->name('aspirasi.feedback');
        Route::post('/aspirasi/{id}/progres', [PetugasAspirasiController::class, 'storeProgres'])->name('aspirasi.progres');

        Route::delete('/aspirasi/{id}', [PetugasAspirasiController::class, 'destroy'])->name('aspirasi.destroy');

        Route::get('/history', [PetugasAspirasiController::class, 'history'])->name('history');
    });


/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

        Route::get('/aspirasi/create', [SiswaAspirasiController::class, 'create'])->name('aspirasi.create');
        Route::post('/aspirasi', [SiswaAspirasiController::class, 'store'])->name('aspirasi.store');

        Route::get('/aspirasi/status', [SiswaAspirasiController::class, 'status'])->name('aspirasi.status');
        Route::get('/aspirasi/history', [SiswaAspirasiController::class, 'history'])->name('aspirasi.history');

        Route::get('/aspirasi/{id}', [SiswaAspirasiController::class, 'detail'])->name('aspirasi.detail');
    });