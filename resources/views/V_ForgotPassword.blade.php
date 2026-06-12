@extends('layouts.V_Auth')

@section('title', 'Lupa Password - SIMBRO')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full card-form p-8 text-center">
        <div class="mb-6">
            <img src="{{ asset('images/logo-simbro-1.png') }}" alt="SIMBRO" class="w-20 h-20 mx-auto object-contain">
            <h2 class="text-2xl font-black mt-2">Lupa Password?</h2>
            <p class="text-gray-500 text-sm mt-1">Masukkan username Anda, kami akan kirim OTP ke email terdaftar</p>
        </div>
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm rounded text-left">
                @php
                    $hasEmpty = false;
                    $hasInvalid = false;
                    foreach ($errors->all() as $err) {
                        if (str_contains($err, 'harus diisi')) $hasEmpty = true;
                        if (str_contains($err, 'tidak sesuai') || str_contains($err, 'tidak ditemukan')) $hasInvalid = true;
                    }
                @endphp
                {{ $hasInvalid ? 'Data tidak sesuai, harap isi kembali.' : ($hasEmpty ? 'Harap isi data dengan lengkap' : 'Data tidak sesuai') }}
            </div>
        @endif

        <form method="POST" action="{{ route('send.otp') }}" class="space-y-5">
            @csrf
            <div>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Username"
                    class="w-full px-4 py-3 rounded-xl border @error('username') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none">
                @error('username')
                    <div class="text-red-500 text-xs mt-1 text-left">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] text-white hover:bg-orange-700 font-bold py-3 rounded-md transition">
                Kirim OTP
            </button>
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#FF6B00]">← Kembali ke Login</a>
            </div>
        </form>
    </div>
    <div class="mt-6 text-center text-xs text-gray-400">
        &copy; 2026 CV. Mitra Gemuk Bersama. All Rights Reserved.
    </div>
</div>
@endsection
