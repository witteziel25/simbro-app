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
                <div><input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
                <div><input type="email" name="email" placeholder="Email" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
                <div><input type="text" name="no_hp" placeholder="No. Telepon" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
                <div><input type="text" name="username" placeholder="Username" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
            </div>
            <div><textarea name="alamat" rows="2" placeholder="Alamat Lengkap" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></textarea></div>
            <div class="grid md:grid-cols-2 gap-4">
                <div><input type="password" name="password" placeholder="Password" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
                <div><input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full px-4 py-2.5 rounded-xl border focus:border-[#FF6B00] outline-none" required></div>
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] text-white font-bold py-3 rounded-xl shadow-lg">Daftar</button>
            <p class="text-center text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-[#FF6B00] font-semibold">Masuk</a></p>
        </form>
    </div>
    <div class="mt-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} CV. Mitra Gemuk Bersama. All Rights Reserved.
    </div>
</div>
@endsection
