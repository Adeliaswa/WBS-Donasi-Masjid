<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationCategoryController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BeneficiaryCategoryController;
use App\Http\Controllers\DistributionController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman login hanya untuk pengguna yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.process');
});

// Halaman internal hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD Donasi
    Route::resource('donations', DonationController::class)
    ->whereNumber('donation');

    Route::post('/donation-categories', [DonationCategoryController::class, 'store'])
    ->name('donation-categories.store');

    // CRUD Penerima Manfaat
    Route::resource('beneficiaries', BeneficiaryController::class)
        ->whereNumber('beneficiary');
    
    // CRUD Penyaluran Bantuan
    Route::post(
        '/distributions/check-duplicates',
        [DistributionController::class, 'checkDuplicates']
    )->name('distributions.check-duplicates');

    Route::resource('distributions', DistributionController::class)
        ->whereNumber('distribution');

    // Pengelolaan Kategori Penerima Manfaat
    Route::resource(
        'beneficiary-categories',
        BeneficiaryCategoryController::class
    )->parameters([
        'beneficiary-categories' => 'beneficiaryCategory',
    ])->whereNumber('beneficiaryCategory');

    Route::patch(
        '/beneficiary-categories/{beneficiaryCategory}/toggle-status',
        [BeneficiaryCategoryController::class, 'toggleStatus']
    )
        ->whereNumber('beneficiaryCategory')
        ->name('beneficiary-categories.toggle-status');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});
