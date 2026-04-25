@extends('layouts.auth')

@section('title', 'SIMBRO - Mitra Ayam Broiler Premium')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-6 py-12">
    <div class="max-w-4xl text-center">
        <div class="mb-8">
            <div class="w-24 h-24 bg-gradient-to-br from-[#FF6B00] to-orange-500 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
                <i class="fas fa-drumstick-bite text-white text-5xl"></i>
            </div>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-800 mb-4">
            Selamat Datang di <span class="text-[#FF6B00]">SIMBRO</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-8">
            Solusi digital terpercaya untuk pasokan ayam broiler premium.
            Kelola pesanan, pantau stok, dan nikmati kemudahan layanan customer service 24/7.
        </p>
        <div class="flex flex-wrap justify-center gap-5">
            <a href="{{ route('login') }}" class="bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="bg-white border-2 border-[#FF6B00] text-[#FF6B00] hover:bg-orange-50 font-bold py-3 px-8 rounded-full shadow-md transition transform hover:scale-105">
                <i class="fas fa-user-plus mr-2"></i> Daftar
            </a>
        </div>
    </div>
</div>
@endsection
