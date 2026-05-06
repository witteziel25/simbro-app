@extends('layouts.auth')

@section('title', 'Profil Admin - SIMBRO')

@section('content')

<div class="min-h-screen flex flex-col md:flex-row">
    <div class="w-full md:w-80 bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] flex flex-col justify-center px-10 py-10 text-white">
        <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-28 w-28 mb-4">
        <h1 class="text-3xl font-bold mb-3">Profil Admin</h1>
        <p class="text-orange-100 text-sm mb-4">Lihat dan kelola data akun profil Anda. Klik "Edit" untuk mengubah data profil anda.</p>
        <div class="mt-3">
            <i class="fas fa-arrow-left"></i>
            <a href="{{ route('admin.home') }}" class="inline-flex items-center gap-2 text-white hover:underline transition text-sm font-bold"> Kembali ke Beranda Admin</a>
        </div>
    </div>

    <div class="flex-1 bg-white p-6 md:p-60 overflow-y-auto">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-xl font-bold text-gray-800 mb-5 border-l-4 border-[#FF6B00] pl-3">Informasi Akun Admin</h2>

            <form id="profileForm" method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ID Akun</label>
                        <p class="text-gray-700 bg-gray-100 p-2 rounded-lg">{{ $user->user_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                        <div class="view-mode">
                            <p class="text-gray-700 bg-gray-100 p-2 rounded-lg">{{ $user->username }}</p>
                        </div>
                        <div class="edit-mode hidden">
                            <input type="text" name="username" value="{{ $user->username }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                            <div id="error-username" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <div class="view-mode">
                            <p class="text-gray-700 bg-gray-100 p-2 rounded-lg">{{ $user->email }}</p>
                        </div>
                        <div class="edit-mode hidden">
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                            <div id="error-email" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <div class="view-mode">
                            <p class="text-gray-700 bg-gray-100 p-2 rounded-lg">••••••••</p>
                        </div>
                        <div class="edit-mode hidden">
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none pr-10">
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <div id="error-password" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                            <p class="text-xs text-gray-500 mt-1">*Kosongkan jika tidak ingin mengubah password (minimal 8 digit)</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-3 border-t border-gray-100" id="actionButtons">
                    <button type="button" id="editBtn" class="inline-flex items-center gap-2 px-5 py-2 bg-[#FF6B00] text-white rounded-lg hover:bg-orange-700 transition font-medium">
                        <i class="fas fa-edit"></i> Edit Profil
                    </button>
                    <button type="submit" id="saveBtn" class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium hidden">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" id="cancelBtn" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium hidden">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="button" id="logoutBtn" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-red-600 rounded-lg hover:bg-red-50 transition font-medium">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const logoutBtn = document.getElementById('logoutBtn');
        const viewElements = document.querySelectorAll('.view-mode');
        const editElements = document.querySelectorAll('.edit-mode');

        function clearErrors() {
            document.querySelectorAll('.error-text').forEach(el => {
                el.classList.add('hidden');
                el.innerText = '';
            });
        }

        function showErrors(errors) {
            if (errors.username) {
                const errorDiv = document.getElementById('error-username');
                errorDiv.innerText = errors.username[0];
                errorDiv.classList.remove('hidden');
            }
            if (errors.email) {
                const errorDiv = document.getElementById('error-email');
                errorDiv.innerText = errors.email[0];
                errorDiv.classList.remove('hidden');
            }
            if (errors.password) {
                const errorDiv = document.getElementById('error-password');
                errorDiv.innerText = errors.password[0];
                errorDiv.classList.remove('hidden');
            }
        }

        function showLightboxAndThen(message, callback) {
            if (typeof showLightbox === 'function') {
                showLightbox(message, 'error');
                const interval = setInterval(() => {
                    const modal = document.getElementById('lightboxModal');
                    if (modal && modal.classList.contains('invisible')) {
                        clearInterval(interval);
                        if (callback) callback();
                    }
                }, 100);
            } else {
                alert(message);
                if (callback) callback();
            }
        }

        function enterEditMode() {
            viewElements.forEach(el => el.classList.add('hidden'));
            editElements.forEach(el => el.classList.remove('hidden'));
            editBtn.classList.add('hidden');
            saveBtn.classList.remove('hidden');
            cancelBtn.classList.remove('hidden');
            logoutBtn.classList.add('hidden');
            clearErrors();
        }

        function cancelEdit() {
            viewElements.forEach(el => el.classList.remove('hidden'));
            editElements.forEach(el => el.classList.add('hidden'));
            editBtn.classList.remove('hidden');
            saveBtn.classList.add('hidden');
            cancelBtn.classList.add('hidden');
            logoutBtn.classList.remove('hidden');
            clearErrors();
            document.querySelector('input[name="username"]').value = '{{ $user->username }}';
            document.querySelector('input[name="email"]').value = '{{ $user->email }}';
            document.getElementById('password').value = '';
        }

        editBtn.addEventListener('click', enterEditMode);
        cancelBtn.addEventListener('click', cancelEdit);

        const form = document.getElementById('profileForm');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            clearErrors();
            const formData = new FormData(form);
            fetch('{{ route("admin.profile.update") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (typeof showLightbox === 'function') {
                        showLightbox(data.message, 'success');
                    } else {
                        alert(data.message);
                    }
                    const usernameView = document.querySelectorAll('.view-mode p')[0];
                    const emailView = document.querySelectorAll('.view-mode p')[1];
                    if (usernameView) usernameView.innerText = document.querySelector('input[name="username"]').value;
                    if (emailView) emailView.innerText = document.querySelector('input[name="email"]').value;
                    cancelEdit();
                } else {
                    let hasEmpty = false, hasInvalid = false;
                    for (let key in data.errors) {
                        let errMsg = data.errors[key][0];
                        if (errMsg.includes('harus diisi') || errMsg.includes('wajib diisi')) hasEmpty = true;
                        if (errMsg.includes('domain') || errMsg.includes('minimal') || errMsg.includes('sudah digunakan')) hasInvalid = true;
                    }
                    let message = hasInvalid ? 'Data tidak sesuai, harap isi kembali.' : 'Harap isi data dengan lengkap';
                    showLightboxAndThen(message, () => {
                        showErrors(data.errors);
                        const firstError = document.querySelector('.error-text:not(.hidden)');
                        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                }
            })
            .catch(error => {
                if (error.errors) {
                    let hasEmpty = false, hasInvalid = false;
                    for (let key in error.errors) {
                        let errMsg = error.errors[key][0];
                        if (errMsg.includes('harus diisi') || errMsg.includes('wajib diisi')) hasEmpty = true;
                        if (errMsg.includes('domain') || errMsg.includes('minimal') || errMsg.includes('sudah digunakan')) hasInvalid = true;
                    }
                    let message = hasInvalid ? 'Data tidak sesuai, harap isi kembali.' : 'Harap isi data dengan lengkap';
                    showLightboxAndThen(message, () => {
                        showErrors(error.errors);
                        const firstError = document.querySelector('.error-text:not(.hidden)');
                        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                } else if (typeof showLightbox === 'function') {
                    showLightbox('Terjadi kesalahan. Silakan coba lagi.', 'error');
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        logoutBtn.addEventListener('click', () => {
            const confirmAction = () => {
                const logoutForm = document.createElement('form');
                logoutForm.method = 'POST';
                logoutForm.action = '{{ route("logout") }}';
                logoutForm.innerHTML = '@csrf';
                document.body.appendChild(logoutForm);
                logoutForm.submit();
            };
            if (typeof showConfirm === 'function') {
                showConfirm('Apakah anda yakin ingin logout?', confirmAction);
            } else {
                if (confirm('Apakah anda yakin ingin logout?')) confirmAction();
            }
        });
    });
</script>

@endpush

@endsection
