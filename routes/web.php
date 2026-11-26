<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;

// Beranda Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Direktori UMKM & E-Katalog
Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');

// Route Khusus Admin / Stakeholder
Route::middleware(['auth', 'role:admin_pemko'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/umkms/{umkm}/e-catalog', [AdminController::class, 'toggleUmkmCatalog'])
            ->name('umkms.e-catalog');
        Route::post('/umkms/{umkm}/publication', [AdminController::class, 'toggleUmkmPublication'])
            ->name('umkms.publication');
        Route::post('/talents/{talent}/certification', [AdminController::class, 'toggleTalentCertification'])
            ->name('talents.certification');
        Route::post('/talents/{talent}/publication', [AdminController::class, 'toggleTalentPublication'])
            ->name('talents.publication');
        Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])
            ->name('announcements.store');
        Route::post('/announcements/{announcement}/status', [AdminController::class, 'toggleAnnouncementStatus'])
            ->name('announcements.status');
        Route::get('/applications/export', [AdminController::class, 'exportApplications'])
            ->name('applications.export');
        Route::post('/applications/{application}/status', [AdminController::class, 'updateApplicationStatus'])
            ->name('applications.status');
    });

// Route Khusus Pengguna (UMKM, Talenta, Warga)
Route::middleware(['auth', 'role:umkm,talent,citizen'])->group(function () {
    Route::get('/umkm/manage', [UmkmController::class, 'manage'])->name('umkm.manage');
    Route::put('/umkm/manage', [UmkmController::class, 'updateProfile'])->name('umkm.manage.update');
    Route::post('/umkm/manage/products', [UmkmController::class, 'storeProduct'])->name('umkm.products.store');
    Route::put('/umkm/manage/products/{product}', [UmkmController::class, 'updateProduct'])->name('umkm.products.update');
    Route::delete('/umkm/manage/products/{product}', [UmkmController::class, 'destroyProduct'])->name('umkm.products.destroy');

    Route::get('/talent/profile', [TalentController::class, 'editProfile'])->name('talent.profile');
    Route::put('/talent/profile', [TalentController::class, 'updateProfile'])->name('talent.profile.update');
    Route::get('/talent/portfolio', [TalentController::class, 'portfolio'])->name('talent.portfolio');
    Route::get('/talent/portfolio/create', [TalentController::class, 'createPortfolio'])
        ->name('talent.portfolio.create');
    Route::post('/talent/portfolio', [TalentController::class, 'storePortfolio'])
        ->name('talent.portfolio.store');
    Route::put('/talent/portfolio/{portfolio}', [TalentController::class, 'updatePortfolio'])
        ->name('talent.portfolio.update');
    Route::delete('/talent/portfolio/{portfolio}', [TalentController::class, 'destroyPortfolio'])
        ->name('talent.portfolio.destroy');

    // Pengajuan / Lamaran Saya
    Route::get('/my-applications', [AnnouncementController::class, 'myApplications'])
        ->name('announcements.my_applications');
    Route::delete('/my-applications/{application}', [AnnouncementController::class, 'destroyApplication'])
        ->name('announcements.applications.destroy');

    Route::get('/announcements/{announcement}/apply', [AnnouncementController::class, 'apply'])
        ->name('announcements.apply');
    Route::post('/announcements/{announcement}/apply', [AnnouncementController::class, 'submitApplication'])
        ->name('announcements.submit');
});

Route::get('/umkm/{umkm}', [UmkmController::class, 'show'])->name('umkm.show');

// Direktori Medan Talent Hub
Route::get('/talents', [TalentController::class, 'index'])->name('talents.index');

// Papan Pengumuman Pengadaan & Lowongan Proyek
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

// Otentikasi Terpisah (Pengguna vs Link Khusus Admin)
Route::get('/login', function () {
    return redirect('/')->with('auth_required', true);
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
});

Route::get('/forgot-password', [AuthController::class, 'requestPasswordReset'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendPasswordReset'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showPasswordReset'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');