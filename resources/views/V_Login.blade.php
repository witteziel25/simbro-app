@extends('layouts.auth')

@section('title', 'Masuk - SIMBRO')

@section('content')

<div class="min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border p-8">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-simbro-1.png') }}" alt="SIMBRO" class="w-20 h-20 mx-auto object-contain">
            <h1 class="text-2xl font-black mt-2">Masuk ke <span class="text-[#FF6B00]">SIMBRO</span></h1>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-3 rounded-xl text-sm mb-4">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-4">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="mb-4">
                <input type="text" name="username" id="username" placeholder="Username"
                    class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none"
                    required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">
            </div>
            <div class="mb-4 relative">
                <input type="password" name="password" id="password" placeholder="Password"
                    class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none pr-10"
                    required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">
                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                    <i class="fas fa-eye-slash"></i>
                </button>
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

@push('scripts')
<script>
    document.getElementById('username')?.addEventListener('input', function() { this.setCustomValidity(''); });
    document.getElementById('password')?.addEventListener('input', function() { this.setCustomValidity(''); });
</script>
@endpush

@endsection
