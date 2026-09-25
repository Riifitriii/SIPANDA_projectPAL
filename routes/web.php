<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// halaman publik
Route::get('/', [PublicController::class, 'landing'])->name('landing');
Route::get('/ajukan', [PublicController::class, 'showForm'])->name('ajukan');
Route::post('/ajukan', [PublicController::class, 'submitForm'])->name('ajukan.submit');
Route::get('/cek-status', [PublicController::class, 'showStatusForm'])->name('cek-status');
Route::post('/cek-status', [PublicController::class, 'checkStatus'])->name('cek-status.submit');

// Alur Perbaikan Data Pengajuan (Edit In-Place Tanpa Akun)
Route::get('/pengajuan/{nomor_pengajuan}/perbaikan', [PublicController::class, 'showPerbaikanForm'])->name('pengajuan.perbaikan');
Route::post('/pengajuan/{nomor_pengajuan}/perbaikan/verifikasi', [PublicController::class, 'verifyPerbaikanPhone'])->name('pengajuan.perbaikan.verifikasi');
Route::put('/pengajuan/{nomor_pengajuan}/perbaikan', [PublicController::class, 'updatePerbaikan'])->name('pengajuan.perbaikan.update');
Route::post('/pengajuan/{nomor_pengajuan}/perbaikan', [PublicController::class, 'updatePerbaikan']);








// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// autentikasi admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/pengajuan', [AdminController::class, 'listPengajuan'])->name('pengajuan');
    Route::get('/pengajuan/{id}', [AdminController::class, 'detailPengajuan'])->name('pengajuan.detail');
    Route::post('/pengajuan/{id}/verifikasi', [AdminController::class, 'verifyPengajuan'])->name('pengajuan.verifikasi');
    
    Route::get('/umkm', [AdminController::class, 'listUmkm'])->name('umkm');
    
    Route::get('/laporan', [AdminController::class, 'printLaporan'])->name('laporan');

    // Khusus Super Admin
    Route::middleware('super_admin')->group(function () {
        Route::get('/kelola-admin', [AdminController::class, 'kelolaAdmin'])->name('kelola-admin');
        Route::post('/kelola-admin', [AdminController::class, 'storeAdmin'])->name('kelola-admin.store');
        Route::delete('/kelola-admin/{id}', [AdminController::class, 'destroyAdmin'])->name('kelola-admin.destroy');
        Route::get('/log-aktivitas', [AdminController::class, 'logAktivitas'])->name('log-aktivitas');
    });
});

// Temporary Route to Migrate Database on Vercel
Route::get('/migrate-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        return "Database migration and seeding completed successfully!";
    } catch (\Exception $e) {
        return "Error migrating database: " . $e->getMessage();
    }
});

