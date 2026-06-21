@extends('layouts.V_App', ['hide_navbar' => true, 'hide_footer' => true])

@section('title', 'Akun Dinonaktifkan - SIMBRO')

@section('content')
<div class="bg-gray-50 flex flex-col items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-[#FF6B00]">
        <!-- Ikon peringatan berwarna oranye besar -->
        <div class="mb-6 flex justify-center">
            <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-5xl text-[#FF6B00]"></i>
            </div>
        </div>

        <!-- Teks Akun anda dinonaktifkan -->
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Akun Anda Dinonaktifkan</h1>

        <!-- Teks informasi -->
        <p class="text-gray-600 mb-6 leading-relaxed">
            Mohon maaf <strong>{{ session('nama_lengkap', 'Customer') }}</strong>, saat ini akun anda sedang dinonaktifkan karena alasan tertentu. Silahkan menghubungi nomor bantuan (<a href="https://wa.me/628819124538" class="text-[#FF6B00] hover:underline font-semibold">+628819124538</a>) untuk menindaklanjuti.
        </p>

        <div class="mb-6 text-center">
            <a href="{{ route('login') }}" class="inline-block bg-[#FF6B00] text-white hover:bg-orange-700 font-bold py-2.5 px-6 rounded-md transition">
                Kembali ke Masuk
            </a>
        </div>

        <!-- Logo SIMBRO -->
        <div class="flex items-center justify-center gap-2 pt-6 border-t border-gray-100 mt-2">
            <img src="{{ asset('images/logo-simbro-1.png') }}" alt="Logo" class="h-8 md:h-10 w-auto">
            <span class="text-xl md:text-2xl font-black tracking-wider text-[#FF6B00]">SIMBRO</span>
        </div>
    </div>
</div>
@endsection
