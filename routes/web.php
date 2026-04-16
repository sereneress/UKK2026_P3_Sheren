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

// ❗ FIX UTAMA DI SINI
Route::get('/', [LoginController::class, 'showLoginForm']); // tanpa name
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // login name di sini
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register');


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
            'petugas' => redirect()->route('petugas.dashboard'),
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

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // USERS
        Route::prefix('users')->group(function () {
            Route::get('/siswa', [DashboardController::class, 'siswa'])->name('users.siswa');
            Route::get('/guru', [DashboardController::class, 'guru'])->name('users.guru');
            Route::get('/petugas', [DashboardController::class, 'petugas'])->name('users.petugas');
        });

        // SISWA
        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::post('/store', [DashboardController::class, 'storeSiswa'])->name('store');
            Route::put('/{id}', [DashboardController::class, 'updateSiswa'])->name('update');
            Route::delete('/{id}', [DashboardController::class, 'destroySiswa'])->name('destroy');
        });

        // GURU
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::post('/store', [DashboardController::class, 'storeGuru'])->name('store');
            Route::put('/{id}', [DashboardController::class, 'updateGuru'])->name('update');
            Route::delete('/{id}', [DashboardController::class, 'destroyGuru'])->name('destroy');
        });

        // PETUGAS
        Route::prefix('petugas')->name('petugas.')->group(function () {
            Route::post('/store', [DashboardController::class, 'storePetugas'])->name('store');
            Route::put('/{id}', [DashboardController::class, 'updatePetugas'])->name('update');
            Route::delete('/{id}', [DashboardController::class, 'destroyPetugas'])->name('destroy');
        });

        // KATEGORI
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/', [DashboardController::class, 'kategori'])->name('index');
            Route::post('/', [DashboardController::class, 'storeKategori'])->name('store');
            Route::put('/{id}', [DashboardController::class, 'updateKategori'])->name('update');
            Route::delete('/{id}', [DashboardController::class, 'destroyKategori'])->name('destroy');
        });

        // KELAS
        Route::prefix('kelas')->name('kelas.')->group(function () {
            Route::get('/', [DashboardController::class, 'kelas'])->name('index');
            Route::post('/', [DashboardController::class, 'storeKelas'])->name('store');
            Route::put('/{id}', [DashboardController::class, 'updateKelas'])->name('update');
            Route::delete('/{id}', [DashboardController::class, 'destroyKelas'])->name('destroy');
        });

        // JURUSAN
        Route::prefix('jurusan')->name('jurusan.')->group(function () {
            Route::get('/', [DashboardController::class, 'jurusan'])->name('index');
            Route::post('/', [DashboardController::class, 'storeJurusan'])->name('store');
            Route::put('/{id}', [DashboardController::class, 'updateJurusan'])->name('update');
            Route::delete('/{id}', [DashboardController::class, 'destroyJurusan'])->name('destroy');
        });

        // RUANGAN
        Route::prefix('ruangan')->name('ruangan.')->group(function () {
            Route::get('/', [DashboardController::class, 'ruangan'])->name('index');
            Route::post('/', [DashboardController::class, 'storeRuangan'])->name('store');
            Route::put('/{id}', [DashboardController::class, 'updateRuangan'])->name('update');
            Route::delete('/{id}', [DashboardController::class, 'destroyRuangan'])->name('destroy');
        });

        // PENGADUAN
        Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
            Route::get('/', [DashboardController::class, 'pengaduan'])->name('index');
            Route::put('/{id}/status', [DashboardController::class, 'updateStatus'])->name('status');
            Route::delete('/{id}', [DashboardController::class, 'destroyAspirasi'])->name('destroy');
        });
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

        Route::prefix('aspirasi')->group(function () {
            Route::get('/create', [GuruAspirasiController::class, 'create'])->name('aspirasi.create');
            Route::get('/', [GuruAspirasiController::class, 'index'])->name('aspirasi.index');
            Route::get('/history', [GuruAspirasiController::class, 'history'])->name('aspirasi.history');
            Route::get('/{id}', [GuruAspirasiController::class, 'detail'])->name('aspirasi.detail');
            Route::post('/aspirasi', [GuruAspirasiController::class, 'store'])->name('aspirasi.store');
            Route::delete('/{id}', [GuruAspirasiController::class, 'destroy'])->name('aspirasi.destroy');
        });
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

        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

        Route::get('/aspirasi', [PetugasDashboardController::class, 'aspirasiIndex'])->name('aspirasi.index');
        Route::get('/aspirasi/{id}', [PetugasDashboardController::class, 'aspirasiDetail'])->name('aspirasi.detail');

        Route::post('/aspirasi/{id}/status', [PetugasDashboardController::class, 'updateStatus'])->name('aspirasi.status');
        Route::post('/aspirasi/{id}/feedback', [PetugasDashboardController::class, 'storeFeedback'])->name('aspirasi.feedback');
        Route::post('/aspirasi/{id}/progres', [PetugasDashboardController::class, 'storeProgres'])->name('aspirasi.progres');

        Route::get('/history', [PetugasDashboardController::class, 'history'])->name('history');
        Route::get('/profile', [PetugasDashboardController::class, 'profile'])->name('profile');
    });

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES (for all roles)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile/my-account', [\App\Http\Controllers\ProfileController::class, 'myAccount'])->name('profile.my-account');
    Route::get('/profile/settings', [\App\Http\Controllers\ProfileController::class, 'settings'])->name('profile.settings');
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

        Route::prefix('aspirasi')->group(function () {
            Route::get('/create', [SiswaAspirasiController::class, 'create'])->name('aspirasi.create');
            Route::get('/', [SiswaAspirasiController::class, 'index'])->name('aspirasi.index');
            Route::get('/history', [SiswaAspirasiController::class, 'history'])->name('aspirasi.history');
            Route::get('/{id}', [SiswaAspirasiController::class, 'detail'])->name('aspirasi.detail');
            Route::post('/aspirasi', [SiswaAspirasiController::class, 'store'])->name('aspirasi.store');
            Route::delete('/{id}', [SiswaAspirasiController::class, 'destroy'])->name('aspirasi.destroy');
        });
        Route::get('/history', [SiswaAspirasiController::class, 'history'])->name('history');
    });
