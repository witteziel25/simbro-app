@extends('layouts.auth')

@section('title', 'Masuk - SIMBRO')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border p-8">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-simbro-1.png') }}" alt="SIMBRO" class="w-20 h-20 mx-auto object-contain">
            <h1 class="text-2xl font-black mt-2">Masuk ke <span class="text-[#FF6B00]">SIMBRO</span></h1>
        </div>

        {{-- Error summary --}}
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm rounded">
                @php
                    $hasEmpty = false;
                    $hasInvalid = false;
                    foreach ($errors->all() as $err) {
                        if (str_contains($err, 'harus diisi')) $hasEmpty = true;
                        if (str_contains($err, 'tidak ditemukan') || str_contains($err, 'salah')) $hasInvalid = true;
                    }
                @endphp
                {{ $hasInvalid ? 'Data tidak sesuai, silahkan isi kembali.' : ($hasEmpty ? 'Harap isi data dengan lengkap' : 'Data tidak sesuai') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            {{-- Username field --}}
            <div class="mb-4">
                <input type="text" name="username" id="username" placeholder="Username" value="{{ old('username') }}"
                    class="w-full px-4 py-3 rounded-xl border @error('username') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none">
                @error('username')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password field --}}
            <div class="mb-4">
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password"
                        class="w-full px-4 py-3 rounded-xl border @error('password') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none pr-10">
                    <button type="button" onclick="togglePassword('password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i id="icon_password" class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-between text-sm mb-6">
                <a href="{{ route('password.request') }}" class="text-[#FF6B00] hover:underline">Lupa Password</a>
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 rounded-xl shadow-lg transition">
                Masuk
            </button>
        </form>
        <div class="mt-6 text-center">
            <a href="{{ route('landing') }}" class="text-sm text-gray-500 hover:text-[#FF6B00]">← Kembali ke Landing Page</a>
        </div>
    </div>
    <div class="mt-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} CV. Mitra Gemuk Bersama. All Rights Reserved.
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const input = document.getElementById(fieldId);
        const icon = document.getElementById('icon_' + fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
@endsection
