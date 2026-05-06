@extends('layouts.auth')

@section('title', 'Daftar - SIMBRO')

@section('content')

<div class="min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl border p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-simbro-1.png') }}" alt="SIMBRO" class="w-20 h-20 mx-auto object-contain">
            <h2 class="text-2xl font-black mt-2">Daftar Akun Baru</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-4">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}"
                        class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none"
                        required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none"
                        required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">
                </div>
                <div>
                    <input type="text" name="no_hp" placeholder="No. Telepon (10-13 digit)" value="{{ old('no_hp') }}"
                        class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none"
                        required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">
                </div>
                <div>
                    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}"
                        class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none"
                        required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">
                </div>
            </div>
            <div>
                <textarea name="alamat" rows="2" placeholder="Alamat Lengkap"
                    class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none"
                    required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">{{ old('alamat') }}</textarea>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password"
                        class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none pr-10"
                        required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">
                    <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password"
                        class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none pr-10"
                        required oninvalid="this.setCustomValidity('Harap isi data dengan lengkap')" oninput="this.setCustomValidity('')">
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] text-white font-bold py-3 rounded-xl shadow-lg">Daftar</button>
            <div class="text-center">
                <a href="{{ route('landing') }}" class="text-sm text-gray-500 hover:text-[#FF6B00]">← Kembali ke Landing Page</a>
            </div>
        </form>
    </div>
    <div class="mt-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} CV. Mitra Gemuk Bersama. All Rights Reserved.
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('input, textarea, select').forEach(el => {
        el.addEventListener('input', function() { this.setCustomValidity(''); });
    });
</script>
@endpush

@endsection
