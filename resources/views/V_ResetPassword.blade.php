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
        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-4">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Password Baru" class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none pr-10" required>
                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" class="w-full px-4 py-3 rounded-xl border focus:border-[#FF6B00] outline-none pr-10" required>
                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] text-white font-bold py-3 rounded-xl shadow-lg">Reset Password</button>
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-[#FF6B00] hover:underline">← Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
@endsection
