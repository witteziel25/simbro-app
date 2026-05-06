@extends('layouts.auth')

@section('title', 'Lupa Password - SIMBRO')

@section('content')

<div class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border p-8 text-center">
        <div class="mb-6">
            <img src="{{ asset('images/logo-simbro-1.png') }}" alt="SIMBRO" class="w-20 h-20 mx-auto object-contain">
            <h2 class="text-2xl font-black mt-2">Lupa Password?</h2>
            <p class="text-gray-500 text-sm mt-1">Masukkan username Anda, kami akan kirim OTP ke email terdaftar</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-4">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('send.otp') }}" class="space-y-5">
            @csrf
            <div>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Username"
                    class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none"
                    required oninvalid="this.setCustomValidity('Username wajib diisi')" oninput="this.setCustomValidity('')">
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] text-white font-bold py-3 rounded-xl shadow-lg hover:bg-orange-700 transition">
                Kirim OTP
            </button>
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#FF6B00] hover:underline">← Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.querySelector('input[name="username"]')?.addEventListener('input', function() { this.setCustomValidity(''); });
</script>
@endpush

@endsection
