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

// Public Guest Routes
Route::get('/', [PublicController::class, 'landing'])->name('landing');
Route::get('/ajukan', [PublicController::class, 'showForm'])->name('ajukan');
Route::post('/ajukan', [PublicController::class, 'submitForm'])->name('ajukan.submit');
Route::get('/cek-status', [PublicController::class, 'showStatusForm'])->name('cek-status');
Route::post('/cek-status', [PublicController::class, 'checkStatus'])->name('cek-status.submit');

// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Admin Protected Routes (Require admin authentication)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Submissions / Pengajuan Management
    Route::get('/pengajuan', [AdminController::class, 'listPengajuan'])->name('pengajuan');
    Route::get('/pengajuan/{id}', [AdminController::class, 'detailPengajuan'])->name('pengajuan.detail');
    Route::post('/pengajuan/{id}/verifikasi', [AdminController::class, 'verifyPengajuan'])->name('pengajuan.verifikasi');
    
    // Registered UMKM
    Route::get('/umkm', [AdminController::class, 'listUmkm'])->name('umkm');
    
    // Printing / Reporting
    Route::get('/laporan', [AdminController::class, 'printLaporan'])->name('laporan');
});


