@extends('layouts.auth')

@section('title', 'Verifikasi OTP - SIMBRO')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border p-8 text-center">
        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-key text-3xl text-[#FF6B00]"></i>
        </div>
        <h2 class="text-2xl font-black">Verifikasi Kode OTP</h2>
        <p class="text-gray-500 text-sm mt-1">Masukkan 4 digit kode yang dikirim</p>
        @if(session('info'))
            <div class="bg-blue-50 text-blue-700 p-2 rounded-lg text-xs mt-3">{{ session('info') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-2 rounded-lg text-sm mt-3">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('verify.otp') }}" class="mt-6 space-y-6">
            @csrf
            <div class="flex justify-center gap-3">
                <input type="text" name="otp1" maxlength="1" class="w-14 h-14 text-center text-2xl font-bold border rounded-xl focus:border-[#FF6B00] outline-none" required>
                <input type="text" name="otp2" maxlength="1" class="w-14 h-14 text-center text-2xl font-bold border rounded-xl focus:border-[#FF6B00] outline-none" required>
                <input type="text" name="otp3" maxlength="1" class="w-14 h-14 text-center text-2xl font-bold border rounded-xl focus:border-[#FF6B00] outline-none" required>
                <input type="text" name="otp4" maxlength="1" class="w-14 h-14 text-center text-2xl font-bold border rounded-xl focus:border-[#FF6B00] outline-none" required>
            </div>
            <button type="submit" class="w-full bg-[#FF6B00] text-white font-bold py-3 rounded-xl shadow-lg">Konfirmasi</button>
        </form>
    </div>
</div>
<script>
    document.querySelectorAll('input[name^="otp"]').forEach((input, index, arr) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && index < arr.length-1) arr[index+1].focus();
        });
    });
</script>
@endsection
