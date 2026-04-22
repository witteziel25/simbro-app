@extends('layouts.auth')

@section('title', 'Masuk - SIMBRO')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-drumstick-bite text-3xl text-[#FF6B00]"></i>
            </div>
            <h1 class="text-2xl font-black">Masuk ke <span class="text-[#FF6B00]">SIMBRO</span></h1>
        </div>
        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-4">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none" required>
            </div>
            <div class="flex justify-between text-sm mb-6">
                <a href="{{ route('password.request') }}" class="text-[#FF6B00]">Lupa Password</a>
                <a href="{{ route('register') }}" class="text-[#FF6B00]">Daftar</a>
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] text-white font-bold py-3 rounded-xl shadow-lg">Masuk</button>
        </form>
    </div>
    <div class="mt-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} CV. Mitra Gemuk Bersama. All Rights Reserved.
    </div>
</div>
@endsection
