<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationCategoryController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BeneficiaryCategoryController;
use App\Http\Controllers\DistributionController;


// ==================================================
// HALAMAN UTAMA
// ==================================================

Route::get('/', function () {
    return view('welcome');
});


// ==================================================
// AUTENTIKASI
// Hanya untuk pengguna yang belum login
// ==================================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.process');

});


// ==================================================
// HALAMAN INTERNAL
// Hanya dapat diakses setelah login
// ==================================================

Route::middleware('auth')->group(function () {


    // ==============================================
    // DASHBOARD
    // ==============================================

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // ==============================================
    // CRUD DONASI
    // ==============================================

    Route::resource('donations', DonationController::class)
        ->whereNumber('donation');

    Route::post(
        '/donation-categories',
        [DonationCategoryController::class, 'store']
    )->name('donation-categories.store');


    // ==============================================
    // CRUD PENERIMA MANFAAT
    // ==============================================

    Route::resource('beneficiaries', BeneficiaryController::class)
        ->whereNumber('beneficiary');


    // ==============================================
    // CRUD PENYALURAN BANTUAN
    // ==============================================

    // Pemeriksaan duplikasi penyaluran
    Route::post(
        '/distributions/check-duplicates',
        [DistributionController::class, 'checkDuplicates']
    )->name('distributions.check-duplicates');

    Route::resource('distributions', DistributionController::class)
        ->whereNumber('distribution');


    // ==============================================
    // PENGELOLAAN KATEGORI PENERIMA MANFAAT
    // ==============================================

    Route::resource(
        'beneficiary-categories',
        BeneficiaryCategoryController::class
    )->parameters([
        'beneficiary-categories' => 'beneficiaryCategory',
    ])->whereNumber('beneficiaryCategory');

    // Mengubah status kategori
    Route::patch(
        '/beneficiary-categories/{beneficiaryCategory}/toggle-status',
        [BeneficiaryCategoryController::class, 'toggleStatus']
    )
        ->whereNumber('beneficiaryCategory')
        ->name('beneficiary-categories.toggle-status');


    // ==============================================
    // LOGOUT
    // ==============================================

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

});
