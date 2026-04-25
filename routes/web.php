<?php

use App\Http\Controllers\C_Authentication;
use App\Http\Controllers\C_Profil;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () { return view('V_Landing'); })->name('landing');

// Auth
Route::get('/login', [C_Authentication::class, 'showFormLogin'])->name('login');
Route::get('/register', [C_Authentication::class, 'showFormRegister'])->name('register');
Route::post('/login', [C_Authentication::class, 'klikLogin'])->name('login.submit');
Route::post('/register', [C_Authentication::class, 'klikRegister'])->name('register.submit');
Route::post('/logout', [C_Authentication::class, 'klikLogout'])->name('logout');

// Lupa password
Route::get('/forgot-password', [C_Authentication::class, 'showForgotForm'])->name('password.request');
Route::post('/send-otp', [C_Authentication::class, 'sendOtp'])->name('send.otp');
Route::get('/otp-verification', [C_Authentication::class, 'showOtpForm'])->name('password.otp');
Route::post('/verify-otp', [C_Authentication::class, 'verifyOTP'])->name('verify.otp');
Route::get('/reset-password', [C_Authentication::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [C_Authentication::class, 'resetPassword'])->name('password.update');

// Customer
Route::prefix('customer')->group(function () {
    Route::get('/home', [C_Authentication::class, 'showCustomerHome'])->name('customer.home');
    Route::get('/profile', [C_Profil::class, 'showCustomerProfil'])->name('customer.profile');
    Route::post('/profile/update', [C_Profil::class, 'klikUpdateCustomerProfil'])->name('customer.profile.update');
});

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/home', [C_Authentication::class, 'showAdminHome'])->name('admin.home');
    Route::get('/profile', [C_Profil::class, 'showAdminProfil'])->name('admin.profile');
    Route::post('/profile/update', [C_Profil::class, 'klikUpdateAdminProfil'])->name('admin.profile.update');
    Route::get('/data-customer', [C_Profil::class, 'showDataCustomer'])->name('admin.data.customer');
});
