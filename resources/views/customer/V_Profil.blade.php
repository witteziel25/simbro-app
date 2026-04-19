@extends('layouts.auth')

@section('title', 'Profil Saya - SIMBRO')

@section('content')
<div class="min-h-screen py-8 px-4 md:px-12">
    <div class="max-w-6xl mx-auto mb-6">
        <a href="{{ route('customer.home') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-[#FF6B00] transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-[#FF6B00] to-orange-500 px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-circle text-5xl text-[#FF6B00]"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white" id="displayNama">{{ $user->nama_lengkap }}</h1>
                    <p class="text-orange-100">Customer ID: #{{ $user->user_id }}</p>
                </div>
            </div>
        </div>
        <form id="profileForm" class="p-8 md:p-10 space-y-6">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->user_id }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">
                <div><label class="block text-sm font-semibold text-gray-600">Nama Lengkap</label><div class="mt-1 view-mode">{{ $user->nama_lengkap }}</div><input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden"></div>
                <div><label class="block text-sm font-semibold text-gray-600">Username</label><div class="mt-1 view-mode">{{ $user->username }}</div><input type="text" name="username" value="{{ $user->username }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden"></div>
                <div><label class="block text-sm font-semibold text-gray-600">Email</label><div class="mt-1 view-mode">{{ $user->email }}</div><input type="email" name="email" value="{{ $user->email }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden"></div>
                <div><label class="block text-sm font-semibold text-gray-600">No. Telepon</label><div class="mt-1 view-mode">{{ $user->no_hp }}</div><input type="text" name="no_hp" value="{{ $user->no_hp }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden"></div>
                <div><label class="block text-sm font-semibold text-gray-600">Password</label><div class="mt-1 view-mode">••••••••</div><input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden"><p class="text-xs text-gray-400 mt-1 edit-mode hidden">*Kosongkan jika tidak ingin mengubah password</p></div>
                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-600">Alamat</label><div class="mt-1 view-mode">{{ $user->alamat }}</div><textarea name="alamat" rows="2" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none hidden">{{ $user->alamat }}</textarea></div>
            </div>
            <div class="flex flex-wrap gap-4 pt-4 border-t">
                <button type="button" id="editBtn" class="bg-[#FF6B00] text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:bg-orange-700 transition"><i class="fas fa-edit mr-2"></i> Edit Profil</button>
                <button type="submit" id="saveBtn" class="bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:bg-green-700 transition hidden"><i class="fas fa-save mr-2"></i> Simpan Perubahan</button>
                <button type="button" id="logoutBtn" class="border border-red-300 text-red-500 px-6 py-2.5 rounded-xl font-semibold hover:bg-red-50 transition"><i class="fas fa-sign-out-alt mr-2"></i> Logout</button>
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
        const displayNama = document.getElementById('displayNama');
        editBtn.addEventListener('click', () => {
            viewElements.forEach(el => el.classList.add('hidden'));
            editElements.forEach(el => el.classList.remove('hidden'));
            editBtn.classList.add('hidden');
            saveBtn.classList.remove('hidden');
        });
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            fetch('{{ route("customer.profile.update") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    const newNama = form.querySelector('input[name="nama_lengkap"]').value;
                    const newUsername = form.querySelector('input[name="username"]').value;
                    const newEmail = form.querySelector('input[name="email"]').value;
                    const newHp = form.querySelector('input[name="no_hp"]').value;
                    const newAlamat = form.querySelector('textarea[name="alamat"]').value;
                    const viewDivs = document.querySelectorAll('.view-mode');
                    viewDivs[0].innerText = newNama;
                    viewDivs[1].innerText = newUsername;
                    viewDivs[2].innerText = newEmail;
                    viewDivs[3].innerText = newHp;
                    viewDivs[4].innerText = newAlamat;
                    displayNama.innerText = newNama;
                    viewElements.forEach(el => el.classList.remove('hidden'));
                    editElements.forEach(el => el.classList.add('hidden'));
                    editBtn.classList.remove('hidden');
                    saveBtn.classList.add('hidden');
                } else alert('Gagal memperbarui data');
            }).catch(() => alert('Terjadi kesalahan, silakan coba lagi.'));
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
