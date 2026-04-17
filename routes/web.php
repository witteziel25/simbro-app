<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth-login');
})->name('login');

Route::get('/register', function () {
    return view('auth-register');
})->name('register');

Route::get('/home', function () {
    return view('cust-home');
})->name('customer.home');

Route::get('/profile', function () {
    return view('cust-profile');
})->name('customer.profile');