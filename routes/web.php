<?php

use App\Http\Controllers\C_Authentication;
use App\Http\Controllers\C_Profil;
use App\Http\Controllers\C_Produk;
use Illuminate\Support\Facades\Route;

// LANDING & AUTH
Route::get('/', fn() => view('V_Landing'))->name('landing');
Route::get('/login', [C_Authentication::class, 'showFormLogin'])->name('login');
Route::get('/register', [C_Authentication::class, 'showFormRegister'])->name('register');
Route::post('/login', [C_Authentication::class, 'klikLogin'])->name('login.submit');
Route::post('/register', [C_Authentication::class, 'klikRegister'])->name('register.submit');
Route::post('/logout', [C_Authentication::class, 'klikLogout'])->name('logout');

// LUPA PASSWORD
Route::get('/forgot-password', [C_Authentication::class, 'showForgotForm'])->name('password.request');
Route::post('/send-otp', [C_Authentication::class, 'sendOtp'])->name('send.otp');
Route::get('/otp-verification', [C_Authentication::class, 'showOtpForm'])->name('password.otp');
Route::post('/verify-otp', [C_Authentication::class, 'verifyOTP'])->name('verify.otp');
Route::get('/reset-password', [C_Authentication::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [C_Authentication::class, 'resetPassword'])->name('password.update');

// CUSTOMER
Route::middleware(['role:0'])->prefix('customer')->group(function () {
    Route::get('/home', [C_Authentication::class, 'showHome'])->name('customer.home');
    Route::get('/profile', [C_Profil::class, 'showCustomerProfil'])->name('customer.profile');
    Route::post('/profile/update', [C_Profil::class, 'klikUpdateCustomerProfil'])->name('customer.profile.update');
});

// ADMIN
Route::middleware(['role:1'])->prefix('admin')->group(function () {
    Route::get('/home', [C_Authentication::class, 'showHome'])->name('admin.home');
    Route::get('/profile', [C_Profil::class, 'showAdminProfil'])->name('admin.profile');
    Route::post('/profile/update', [C_Profil::class, 'klikUpdateAdminProfil'])->name('admin.profile.update');
    Route::get('/data-customer', [C_Profil::class, 'showDataCustomer'])->name('admin.data.customer');
});

// PRODUK
Route::middleware(['role:1'])->prefix('produk')->group(function () {
    Route::get('/tambah', [C_Produk::class, 'showFormTambahDataProduk'])->name('produk.tambah');
    Route::post('/tambah', [C_Produk::class, 'tambahProduk'])->name('produk.store');
    Route::get('/{id}/edit', [C_Produk::class, 'showFormUbahDataProduk'])->name('produk.edit');
    Route::put('/{id}', [C_Produk::class, 'simpan'])->name('produk.update');
    Route::delete('/{id}', [C_Produk::class, 'hapus'])->name('produk.destroy');
    Route::get('/api/{id}', [C_Produk::class, 'salahSatuProduk'])->name('produk.api');
    Route::get('/deleted', [C_Produk::class, 'showDeleted'])->name('produk.deleted');
    Route::post('/restore/{id}', [C_Produk::class, 'restore'])->name('produk.restore');
});
