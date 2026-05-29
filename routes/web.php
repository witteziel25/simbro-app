<?php

use App\Http\Controllers\C_Authentication;
use App\Http\Controllers\C_Profil;
use App\Http\Controllers\C_Produk;
use App\Http\Controllers\C_Transaksi;
use App\Http\Controllers\C_Ulasan;
use App\Http\Controllers\C_Gallery;
use App\Http\Controllers\C_Chatbot;
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

// HALAMAN HOME (role-based)
Route::middleware(['role:0'])->get('/customer/home', [C_Authentication::class, 'showHome'])->name('customer.home');
Route::middleware(['role:1'])->get('/admin/home', [C_Authentication::class, 'showHome'])->name('admin.home');

// PROFIL CUSTOMER
Route::middleware(['role:0'])->prefix('customer')->group(function () {
    Route::get('/profile', [C_Profil::class, 'showCustomerProfil'])->name('customer.profile');
    Route::post('/profile/update', [C_Profil::class, 'klikUpdateCustomerProfil'])->name('customer.profile.update');
});

// PROFIL ADMIN
Route::middleware(['role:1'])->prefix('admin')->group(function () {
    Route::get('/profile', [C_Profil::class, 'showAdminProfil'])->name('admin.profile');
    Route::post('/profile/update', [C_Profil::class, 'klikUpdateAdminProfil'])->name('admin.profile.update');
    Route::get('/data-customer', [C_Profil::class, 'showDataCustomer'])->name('admin.data.customer');
});

// PRODUK (hanya admin)
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

// ========== ADMIN - MANAJEMEN ==========
Route::middleware(['role:1'])->prefix('admin')->group(function () {
    Route::get('/manajemen', [C_Transaksi::class, 'manajemen'])->name('admin.manajemen');

    // Card informasi (CRUD)
    Route::get('/informasi-pembayaran', [C_Transaksi::class, 'showHallInformasiPembayaran'])->name('admin.informasi-pembayaran');
    Route::get('/informasi-pembayaran/create', [C_Transaksi::class, 'showFormTambah'])->name('admin.informasi-pembayaran.create');
    Route::post('/informasi-pembayaran', [C_Transaksi::class, 'simpanInformasi'])->name('admin.informasi-pembayaran.store');
    Route::get('/informasi-pembayaran/{id}/edit', [C_Transaksi::class, 'showFormUbah'])->name('admin.informasi-pembayaran.edit');
    Route::put('/informasi-pembayaran/{id}', [C_Transaksi::class, 'updateInformasi'])->name('admin.informasi-pembayaran.update');
    Route::delete('/informasi-pembayaran/{id}', [C_Transaksi::class, 'hapusInformasi'])->name('admin.informasi-pembayaran.destroy');

    // Rekening bank
    Route::post('/rekening', [C_Transaksi::class, 'simpanRekening'])->name('admin.rekening.store');
    Route::get('/rekening/{id}/edit', [C_Transaksi::class, 'showFormUbahRekening'])->name('admin.rekening.edit');
    Route::put('/rekening/{id}', [C_Transaksi::class, 'updateRekening'])->name('admin.rekening.update');
    Route::delete('/rekening/{id}', [C_Transaksi::class, 'hapusRekening'])->name('admin.rekening.destroy');

    // Transaksi
    Route::get('/transaksi-aktif', [C_Transaksi::class, 'adminTransaksiAktif'])->name('admin.transaksi.aktif');
    Route::get('/riwayat-transaksi', [C_Transaksi::class, 'adminRiwayatTransaksi'])->name('admin.riwayat.transaksi');
    Route::get('/transaksi/{id}', [C_Transaksi::class, 'showDetailTransaksiAdmin'])->name('admin.transaksi.detail');
    Route::put('/transaksi/{id}/status', [C_Transaksi::class, 'updateStatus'])->name('admin.transaksi.update.status');

    Route::get('/laporan-penjualan', [C_Transaksi::class, 'laporanPenjualan'])->name('admin.laporan.penjualan');
    Route::get('/resi/cetak/{transaksi_id}', [C_Transaksi::class, 'cetakResi'])->name('admin.resi.cetak');
});

// ========== CUSTOMER - TRANSAKSI ==========
Route::middleware(['role:0'])->prefix('customer')->group(function () {
    Route::get('/beli/{produk_id}', [C_Transaksi::class, 'beli'])->name('customer.transaksi.beli');
    Route::post('/prepare-checkout/{produk_id}', [C_Transaksi::class, 'prepareCheckout'])->name('customer.transaksi.prepare');
    Route::post('/clear-checkout', [C_Transaksi::class, 'clearCheckoutSession'])->name('customer.transaksi.clear');
    Route::post('/store-transaksi', [C_Transaksi::class, 'storeTransaksiWithBukti'])->name('customer.transaksi.store');
    Route::get('/riwayat-transaksi', [C_Transaksi::class, 'showRiwayatTransaksi'])->name('customer.riwayat.transaksi');
    Route::post('/transaksi/batalkan/{transaksi_id}', [C_Transaksi::class, 'batalkanPesanan'])->name('customer.transaksi.batalkan');
    Route::get('/resi/cetak/{transaksi_id}', [C_Transaksi::class, 'cetakResi'])->name('customer.resi.cetak');
    Route::post('/ulasan', [C_Ulasan::class, 'store'])->name('customer.ulasan.store');
    Route::delete('/ulasan/{id}', [C_Ulasan::class, 'destroy'])->name('customer.ulasan.destroy');
});

// ========== GALLERY (ADMIN) ==========
Route::middleware(['role:1'])->prefix('admin')->group(function () {
    Route::get('/gallery/create', [C_Gallery::class, 'create'])->name('admin.gallery.create');
    Route::post('/gallery', [C_Gallery::class, 'store'])->name('admin.gallery.store');
    Route::get('/gallery/{id}/edit', [C_Gallery::class, 'edit'])->name('admin.gallery.edit');
    Route::put('/gallery/{id}', [C_Gallery::class, 'update'])->name('admin.gallery.update');
    Route::delete('/gallery/{id}', [C_Gallery::class, 'destroy'])->name('admin.gallery.destroy');
});

// ========== GALLERY (PUBLIC) ==========
Route::get('/gallery/{id}', [C_Gallery::class, 'show'])->name('gallery.article');

// Chatbot AI
Route::middleware(['role:0,1'])->prefix('chatbot')->group(function () {
    Route::get('/', [C_Chatbot::class, 'index'])->name('chatbot.index');
    Route::post('/send', [C_Chatbot::class, 'sendMessage'])->name('chatbot.send');
    Route::post('/clear', [C_Chatbot::class, 'clearSession'])->name('chatbot.clear');
});
