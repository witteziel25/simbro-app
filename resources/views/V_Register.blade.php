@extends('layouts.auth')

@section('title', 'Daftar - SIMBRO')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl border p-8">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-user-plus text-2xl text-[#FF6B00]"></i>
            </div>
            <h2 class="text-2xl font-black">Daftar Akun Baru</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-4">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div><input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
                <div><input type="email" name="email" placeholder="Email" value="{{ old('email') }}" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
                <div><input type="text" name="no_hp" placeholder="No. Telepon (10-13 digit)" value="{{ old('no_hp') }}" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
                <div><input type="text" name="username" placeholder="Username" value="{{ old('username') }}" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
            </div>
            <div><textarea name="alamat" rows="2" placeholder="Alamat Lengkap" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required>{{ old('alamat') }}</textarea></div>

            <!-- Pilihan Peran -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Peran</label>
                <select name="peran" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required>
                    <option value="">Pilih Peran</option>
                    <option value="peternak" {{ old('peran') == 'peternak' ? 'selected' : '' }}>Peternak</option>
                    <option value="rumah_pemotongan" {{ old('peran') == 'rumah_pemotongan' ? 'selected' : '' }}>Rumah Pemotongan</option>
                </select>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <!-- Password -->
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password" class="w-full px-4 py-2.5 rounded-xl border pr-10" required>
                    <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
                <!-- Konfirmasi Password -->
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" class="w-full px-4 py-2.5 rounded-xl border pr-10" required>
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] text-white font-bold py-3 rounded-xl shadow-lg">Daftar</button>
            <div class="text-center">
                <a href="{{ route('landing') }}" class="text-sm text-gray-500 hover:text-[#FF6B00]">← Kembali ke Beranda</a>
            </div>
        </form>
    </div>
    <div class="mt-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} CV. Mitra Gemuk Bersama. All Rights Reserved.
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
