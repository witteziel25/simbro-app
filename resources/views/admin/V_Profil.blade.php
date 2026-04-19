@extends('layouts.auth')

@section('title', 'Profil Admin - SIMBRO')

@section('content')
<div class="min-h-screen py-8 px-4 md:px-12">
    <div class="max-w-6xl mx-auto mb-6">
        <a href="{{ route('admin.home') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-[#FF6B00] transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda Admin
        </a>
    </div>
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-[#FF6B00] to-orange-500 px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-shield text-5xl text-[#FF6B00]"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Admin SIMBRO</h1>
                    <p class="text-orange-100">ID: #{{ $user->user_id }}</p>
                </div>
            </div>
        </div>
        <form id="profileForm" class="p-8 md:p-10 space-y-6">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->user_id }}">
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-600">Username</label>
                    <div class="mt-1 view-mode">{{ $user->username }}</div>
                    <input type="text" name="username" value="{{ $user->username }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-600">Email</label>
                    <div class="mt-1 view-mode">{{ $user->email }}</div>
                    <input type="email" name="email" value="{{ $user->email }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-600">Password</label>
                    <div class="mt-1 view-mode">••••••••</div>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden">
                    <p class="text-xs text-gray-400 mt-1 edit-mode hidden">*Kosongkan jika tidak ingin mengubah password</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-4 pt-4 border-t">
                <button type="button" id="editBtn" class="bg-[#FF6B00] text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:bg-orange-700 transition">
                    <i class="fas fa-edit mr-2"></i> Edit Profil
                </button>
                <button type="submit" id="saveBtn" class="bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:bg-green-700 transition hidden">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                <button type="button" id="logoutBtn" class="border border-red-300 text-red-500 px-6 py-2.5 rounded-xl font-semibold hover:bg-red-50 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const logoutBtn = document.getElementById('logoutBtn');
        const form = document.getElementById('profileForm');
        const viewElements = document.querySelectorAll('.view-mode');
        const editElements = document.querySelectorAll('.edit-mode');

        editBtn.addEventListener('click', () => {
            viewElements.forEach(el => el.classList.add('hidden'));
            editElements.forEach(el => el.classList.remove('hidden'));
            editBtn.classList.add('hidden');
            saveBtn.classList.remove('hidden');
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            fetch('{{ route("admin.profile.update") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    const newUsername = form.querySelector('input[name="username"]').value;
                    const newEmail = form.querySelector('input[name="email"]').value;
                    const viewDivs = document.querySelectorAll('.view-mode');
                    viewDivs[0].innerText = newUsername;
                    viewDivs[1].innerText = newEmail;
                    viewElements.forEach(el => el.classList.remove('hidden'));
                    editElements.forEach(el => el.classList.add('hidden'));
                    editBtn.classList.remove('hidden');
                    saveBtn.classList.add('hidden');
                } else alert('Gagal memperbarui data');
            }).catch(() => alert('Terjadi kesalahan.'));
        });

        logoutBtn.addEventListener('click', () => {
            if (confirm('Apakah anda yakin ingin logout?')) {
                const logoutForm = document.createElement('form');
                logoutForm.method = 'POST';
                logoutForm.action = '{{ route("logout") }}';
                logoutForm.innerHTML = '@csrf';
                document.body.appendChild(logoutForm);
                logoutForm.submit();
            }
        });
    });
</script>
@endsection
