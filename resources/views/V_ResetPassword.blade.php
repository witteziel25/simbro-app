@extends('layouts.auth')

@section('title', 'Reset Password - SIMBRO')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border p-8">
        <div class="text-center mb-6">
            <i class="fas fa-lock text-4xl text-[#FF6B00]"></i>
            <h2 class="text-2xl font-black mt-2">Buat Password Baru</h2>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-3 rounded-xl text-sm mb-4">{{ session('success') }}</div>
        @endif

        {{-- Error summary --}}
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm rounded">
                @php
                    $hasEmpty = false;
                    $hasInvalid = false;
                    foreach ($errors->all() as $err) {
                        if (str_contains($err, 'harus diisi')) $hasEmpty = true;
                        if (str_contains($err, 'minimal') || str_contains($err, 'tidak sesuai')) $hasInvalid = true;
                    }
                @endphp
                {{ $hasInvalid ? 'Data tidak sesuai, harap isi kembali.' : 'Harap isi data dengan lengkap' }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Password Baru"
                    class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none pr-10"
                    required oninvalid="this.setCustomValidity('Password wajib diisi')" oninput="this.setCustomValidity('')">
                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                    <i class="fas fa-eye-slash"></i>
                </button>
                @error('password')
                    <div class="text-red-500 text-xs mt-1 text-left">{{ $message }}</div>
                @enderror
            </div>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password"
                    class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none pr-10"
                    required oninvalid="this.setCustomValidity('Password wajib diisi')" oninput="this.setCustomValidity('')">
                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                    <i class="fas fa-eye-slash"></i>
                </button>
                @error('password_confirmation')
                    <div class="text-red-500 text-xs mt-1 text-left">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 rounded-xl shadow-lg transition">
                Reset Password
            </button>
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#FF6B00]">← Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('password')?.addEventListener('input', function() { this.setCustomValidity(''); });
    document.getElementById('password_confirmation')?.addEventListener('input', function() { this.setCustomValidity(''); });
</script>
@endpush
@endsection
