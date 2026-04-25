@extends('layouts.auth')

@section('title', 'Profil Saya - SIMBRO')

@section('content')
<div class="min-h-screen py-8 px-4 md:px-12">
    <div class="max-w-6xl mx-auto mb-6">
        <a href="{{ route('customer.home') }}" id="backLink" class="inline-flex items-center gap-2 text-gray-600 hover:text-[#FF6B00] transition">
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
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                    <div class="mt-1 view-mode" id="viewNama">{{ $user->nama_lengkap }}</div>
                    <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none" style="display: none;">
                    <div class="error-container mt-1"></div>
                </div>
                <!-- Username -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Username</label>
                    <div class="mt-1 view-mode" id="viewUsername">{{ $user->username }}</div>
                    <input type="text" name="username" value="{{ $user->username }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none" style="display: none;">
                    <div class="error-container mt-1"></div>
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                    <div class="mt-1 view-mode" id="viewEmail">{{ $user->email }}</div>
                    <input type="email" name="email" value="{{ $user->email }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none" style="display: none;">
                    <div class="error-container mt-1"></div>
                </div>
                <!-- No HP -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">No. Telepon</label>
                    <div class="mt-1 view-mode" id="viewHp">{{ $user->no_hp }}</div>
                    <input type="text" name="no_hp" value="{{ $user->no_hp }}" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none" style="display: none;">
                    <div class="error-container mt-1"></div>
                </div>
                <!-- Peran -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Peran</label>
                    <div class="mt-1 view-mode" id="viewPeran">{{ $user->peran == 'peternak' ? 'Peternak' : 'Rumah Pemotongan' }}</div>
                    <select name="peran" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none" style="display: none;">
                        <option value="peternak" {{ $user->peran == 'peternak' ? 'selected' : '' }}>Peternak</option>
                        <option value="rumah_pemotongan" {{ $user->peran == 'rumah_pemotongan' ? 'selected' : '' }}>Rumah Pemotongan</option>
                    </select>
                    <div class="error-container mt-1"></div>
                </div>
                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                    <div class="mt-1 view-mode">••••••••</div>
                    <div class="edit-mode" style="display: none;">
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-4 py-2 border rounded-xl pr-10">
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">*Kosongkan jika tidak ingin mengubah password (minimal 8 digit jika diisi)</p>
                    </div>
                    <div class="error-container mt-1"></div>
                </div>
                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat</label>
                    <div class="mt-1 view-mode" id="viewAlamat">{{ $user->alamat }}</div>
                    <textarea name="alamat" rows="2" class="edit-mode w-full px-4 py-2 border rounded-xl focus:border-[#FF6B00] outline-none" style="display: none;">{{ $user->alamat }}</textarea>
                    <div class="error-container mt-1"></div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 pt-4 border-t">
                <button type="button" id="editBtn" class="bg-[#FF6B00] text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:bg-orange-700 transition">
                    <i class="fas fa-edit mr-2"></i> Edit Profil
                </button>
                <button type="submit" id="saveBtn" class="bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:bg-green-700 transition" style="display: none;">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                <button type="button" id="cancelBtn" class="bg-gray-500 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md hover:bg-gray-600 transition" style="display: none;">
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <button type="button" id="logoutBtn" class="border border-red-300 text-red-500 px-6 py-2.5 rounded-xl font-semibold hover:bg-red-50 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
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

    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const logoutBtn = document.getElementById('logoutBtn');
        const form = document.getElementById('profileForm');
        const viewElements = document.querySelectorAll('.view-mode');
        const editElements = document.querySelectorAll('.edit-mode');
        const displayNama = document.getElementById('displayNama');
        const backLink = document.getElementById('backLink');

        function enterEditMode() {
            viewElements.forEach(el => el.style.display = 'none');
            editElements.forEach(el => el.style.display = 'block');
            editBtn.style.display = 'none';
            saveBtn.style.display = 'inline-block';
            cancelBtn.style.display = 'inline-block';
            logoutBtn.style.display = 'none';
            if (backLink) backLink.style.display = 'none';
        }

        function cancelEdit() {
            viewElements.forEach(el => el.style.display = 'block');
            editElements.forEach(el => el.style.display = 'none');
            editBtn.style.display = 'inline-block';
            saveBtn.style.display = 'none';
            cancelBtn.style.display = 'none';
            logoutBtn.style.display = 'inline-block';
            if (backLink) backLink.style.display = 'inline-flex';
            document.querySelectorAll('.error-container').forEach(el => el.innerHTML = '');
            document.querySelector('input[name="nama_lengkap"]').value = document.getElementById('viewNama').innerText;
            document.querySelector('input[name="username"]').value = document.getElementById('viewUsername').innerText;
            document.querySelector('input[name="email"]').value = document.getElementById('viewEmail').innerText;
            document.querySelector('input[name="no_hp"]').value = document.getElementById('viewHp').innerText;
            document.querySelector('select[name="peran"]').value = document.getElementById('viewPeran').innerText === 'Peternak' ? 'peternak' : 'rumah_pemotongan';
            document.querySelector('textarea[name="alamat"]').value = document.getElementById('viewAlamat').innerText;
            const pwd = document.getElementById('password');
            if (pwd) pwd.value = '';
        }

        editBtn.addEventListener('click', enterEditMode);
        cancelBtn.addEventListener('click', cancelEdit);

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            fetch('{{ route("customer.profile.update") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        if (response.status === 422 && data.errors) {
                            alert('Data tidak sesuai, harap isi kembali');
                            document.querySelectorAll('.error-container').forEach(el => el.innerHTML = '');
                            for (let field in data.errors) {
                                let inputEl = document.querySelector(`[name="${field}"]`);
                                if (inputEl) {
                                    let container = inputEl.closest('div');
                                    let errorDiv = container.querySelector('.error-container');
                                    if (errorDiv) {
                                        errorDiv.innerHTML = `<span class="text-red-500 text-xs">${data.errors[field][0]}</span>`;
                                    }
                                }
                            }
                            return;
                        } else {
                            throw data;
                        }
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    document.getElementById('viewNama').innerText = form.querySelector('input[name="nama_lengkap"]').value;
                    document.getElementById('viewUsername').innerText = form.querySelector('input[name="username"]').value;
                    document.getElementById('viewEmail').innerText = form.querySelector('input[name="email"]').value;
                    document.getElementById('viewHp').innerText = form.querySelector('input[name="no_hp"]').value;
                    const newPeran = form.querySelector('select[name="peran"]').value;
                    document.getElementById('viewPeran').innerText = newPeran === 'peternak' ? 'Peternak' : 'Rumah Pemotongan';
                    document.getElementById('viewAlamat').innerText = form.querySelector('textarea[name="alamat"]').value;
                    displayNama.innerText = form.querySelector('input[name="nama_lengkap"]').value;
                    cancelEdit();
                }
            })
            .catch(error => {
                console.error(error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
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
