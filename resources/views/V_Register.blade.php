@extends('layouts.V_Auth')

@section('title', 'Daftar - SIMBRO')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl border p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-simbro-1.png') }}" alt="SIMBRO" class="w-20 h-20 mx-auto object-contain">
            <h2 class="text-2xl font-black mt-2">Daftar Akun Baru</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm rounded">
                @php
                    $hasEmpty = false;
                    $hasInvalid = false;
                    foreach ($errors->all() as $err) {
                        if (str_contains($err, 'harus diisi') || str_contains($err, 'wajib diisi') || str_contains($err, 'required')) $hasEmpty = true;
                        if (str_contains($err, 'domain') || str_contains($err, 'minimal') || str_contains($err, 'terdiri dari') || str_contains($err, 'tidak sesuai')) $hasInvalid = true;
                    }
                @endphp
                {{ $hasInvalid ? 'Data tidak sesuai, harap isi kembali.' : ($hasEmpty ? 'Harap isi data dengan lengkap' : 'Data tidak sesuai') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}"
                        class="w-full px-4 py-2.5 rounded-xl border @error('nama_lengkap') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none">
                    @error('nama_lengkap')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none">
                    @error('email')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <input type="text" name="no_hp" placeholder="No. Telepon (10-13 digit)" value="{{ old('no_hp') }}"
                        class="w-full px-4 py-2.5 rounded-xl border @error('no_hp') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none">
                    @error('no_hp')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}"
                        class="w-full px-4 py-2.5 rounded-xl border @error('username') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none">
                    @error('username')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div>
                <textarea name="alamat" rows="2" placeholder="Alamat Lengkap"
                    class="w-full px-4 py-2.5 rounded-xl border @error('alamat') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="Password"
                            class="w-full px-4 py-2.5 rounded-xl border @error('password') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none pr-10">
                        <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i id="icon_password" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password"
                            class="w-full px-4 py-2.5 rounded-xl border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror focus:border-[#FF6B00] outline-none pr-10">
                        <button type="button" onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i id="icon_password_confirmation" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 rounded-xl shadow-lg transition">
                Daftar
            </button>
            <div class="text-center">
                <a href="{{ route('landing') }}" class="text-sm text-gray-500 hover:text-[#FF6B00]">← Kembali ke Landing Page</a>
            </div>
        </form>
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
