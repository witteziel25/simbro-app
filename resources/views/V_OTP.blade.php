@extends('layouts.V_Auth')

@section('title', 'Verifikasi OTP - SIMBRO')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border p-8 text-center">
        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-key text-3xl text-[#FF6B00]"></i>
        </div>
        <h2 class="text-2xl font-black">Verifikasi Kode OTP</h2>
        <p class="text-gray-500 text-sm mt-1">
            Masukkan 4 digit kode yang dikirim ke email
            <strong>{{ session('otp_email') }}</strong>
        </p>

        @if(session('info'))
            <div class="bg-blue-50 text-blue-700 p-2 rounded-lg text-xs mt-3">{{ session('info') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-2 rounded-lg text-sm mt-3">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mt-4 text-sm rounded text-left">
                @php
                    $hasEmpty = false;
                    $hasInvalid = false;
                    foreach ($errors->all() as $err) {
                        if (str_contains($err, 'harus diisi')) $hasEmpty = true;
                        if (str_contains($err, 'tidak sesuai') || str_contains($err, 'kadaluwarsa')) $hasInvalid = true;
                    }
                @endphp
                {{ $hasInvalid ? 'Data tidak sesuai, harap isi kembali.' : ($hasEmpty ? 'Harap isi data dengan lengkap' : 'Data tidak sesuai') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verify.otp') }}" class="mt-6 space-y-6">
            @csrf
            <div class="flex justify-center gap-3" id="otpContainer">
                <input type="text" name="otp1" maxlength="1" value="{{ old('otp1') }}"
                    class="otp-field w-14 h-14 text-center text-2xl font-bold border rounded-xl focus:border-[#FF6B00] outline-none @error('otp') border-red-500 @else border-gray-300 @enderror">
                <input type="text" name="otp2" maxlength="1" value="{{ old('otp2') }}"
                    class="otp-field w-14 h-14 text-center text-2xl font-bold border rounded-xl focus:border-[#FF6B00] outline-none @error('otp') border-red-500 @else border-gray-300 @enderror">
                <input type="text" name="otp3" maxlength="1" value="{{ old('otp3') }}"
                    class="otp-field w-14 h-14 text-center text-2xl font-bold border rounded-xl focus:border-[#FF6B00] outline-none @error('otp') border-red-500 @else border-gray-300 @enderror">
                <input type="text" name="otp4" maxlength="1" value="{{ old('otp4') }}"
                    class="otp-field w-14 h-14 text-center text-2xl font-bold border rounded-xl focus:border-[#FF6B00] outline-none @error('otp') border-red-500 @else border-gray-300 @enderror">
            </div>
            @error('otp')
                <div class="text-red-500 text-xs mt-1 text-center">{{ $message }}</div>
            @enderror

            <button type="submit" class="w-full bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 rounded-xl shadow-lg transition">
                Konfirmasi
            </button>
        </form>
        <div class="mt-6 text-center">
            <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-[#FF6B00]">← Kembali ke Lupa Password</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const otpFields = document.querySelectorAll('.otp-field');

    // Auto focus next field
    otpFields.forEach((field, index) => {
        field.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && index < otpFields.length - 1) {
                otpFields[index + 1].focus();
            }
        });

        // Handle backspace: if current field is empty and backspace is pressed, focus previous field
        field.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value === '') {
                if (index > 0) {
                    otpFields[index - 1].focus();
                }
            }
        });
    });
</script>
@endpush
@endsection
