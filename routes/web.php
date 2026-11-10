<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationCategoryController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BeneficiaryCategoryController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Public\PublicHomeController;
use App\Http\Controllers\Public\PublicReportController;
use App\Http\Controllers\Public\PublicReportPdfController;
use App\Http\Controllers\ActivityController;


// ==================================================
// HALAMAN UTAMA
// ==================================================

Route::get('/', [PublicHomeController::class, 'index'])
    ->name('public.home');

Route::get('/transparansi', [PublicReportController::class, 'index'])
    ->name('public.reports.index');

Route::get('/transparansi/pdf/donasi', [
    PublicReportPdfController::class,
    'donations'
])->name('public.reports.pdf.donations');

Route::get('/transparansi/pdf/penyaluran', [
    PublicReportPdfController::class,
    'distributions'
])->name('public.reports.pdf.distributions');

Route::get('/transparansi', [PublicReportController::class, 'index'])
    ->name('public.reports.index');

Route::get('/transparansi/pdf/donasi', [
    PublicReportPdfController::class,
    'donations'
])->name('public.reports.pdf.donations');

Route::get('/transparansi/pdf/penyaluran', [
    PublicReportPdfController::class,
    'distributions'
])->name('public.reports.pdf.distributions');

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
    // LAPORAN DONASI DAN PENYALURAN
    // ==============================================

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    // ==============================================
    // LAPORAN DONASI DAN PENYALURAN
    // ==============================================

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');


    // ==============================================
    // CRUD DONASI
    // ==============================================

    Route::resource('donations', DonationController::class)
        ->whereNumber('donation');

    // BUG-1 FIX: Membuat kategori donasi wajib login
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
        // CRUD KEGIATAN
        // ==============================================

        Route::resource('activities', ActivityController::class)
            ->whereNumber('activity');

    // ==============================================
    // CRUD KEGIATAN
    // ==============================================

    Route::resource('activities', ActivityController::class)
        ->whereNumber('activity');


    // ==============================================
    // LOGOUT
    // ==============================================

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

});
