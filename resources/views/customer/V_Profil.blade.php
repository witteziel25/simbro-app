@extends('layouts.V_Auth')

@section('title', 'Profil Saya - SIMBRO')

@section('header_title', 'Profil Saya')
@section('header_desc', 'Lihat dan kelola data akun profil Anda. Klik "Edit" untuk mengubah data profil anda.')
@section('header_back_url', route('customer.home'))
@section('header_back_text', 'Kembali ke Beranda')

@section('content')

<div class="flex-1 flex flex-col bg-white">
    <div class="flex-1 p-6 md:p-12 overflow-y-auto bg-gray-50/30 flex items-center">
        <div class="max-w-4xl w-full mx-auto card-form p-8">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[#FF6B00] pl-3">Informasi Akun Customer</h2>
            </div>

            <form id="profileForm" method="POST" action="{{ route('customer.profile.update') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ID</label>
                        <p class="bg-gray-100 p-2 rounded-lg">{{ $user->user_id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="view"><p class="bg-gray-100 p-2 rounded-lg">{{ $user->nama_lengkap }}</p></div>
                        <div class="edit hidden">
                            <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF6B00] outline-none">
                            <div id="error-nama_lengkap" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                        <div class="view"><p class="bg-gray-100 p-2 rounded-lg">{{ $user->username }}</p></div>
                        <div class="edit hidden">
                            <input type="text" name="username" value="{{ $user->username }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF6B00] outline-none">
                            <div id="error-username" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <div class="view"><p class="bg-gray-100 p-2 rounded-lg">{{ $user->email }}</p></div>
                        <div class="edit hidden">
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF6B00] outline-none">
                            <div id="error-email" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon</label>
                        <div class="view"><p class="bg-gray-100 p-2 rounded-lg">{{ $user->no_hp }}</p></div>
                        <div class="edit hidden">
                            <input type="text" name="no_hp" value="{{ $user->no_hp }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF6B00] outline-none">
                            <div id="error-no_hp" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
                        <div class="view"><p class="bg-gray-100 p-2 rounded-lg">{{ $user->alamat }}</p></div>
                        <div class="edit hidden">
                            <textarea name="alamat" rows="2" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF6B00] outline-none">{{ $user->alamat }}</textarea>
                            <div id="error-alamat" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <div class="view"><p class="bg-gray-100 p-2 rounded-lg">••••••••</p></div>
                        <div class="edit hidden">
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF6B00] outline-none pr-10">
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <div id="error-password" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                            <p class="text-xs text-gray-500 mt-1">*Kosongkan jika tidak ingin mengubah password (minimal 8 digit)</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-3 border-t border-gray-100">
                    <button type="button" id="editBtn" class="inline-flex items-center gap-2 px-5 py-2 btn-orange rounded-md hover:bg-orange-700 transition font-medium"><i class="fas fa-edit"></i> Edit Profil</button>
                    <button type="submit" id="saveBtn" class="inline-flex items-center gap-2 px-5 py-2 btn-orange rounded-md hover:bg-orange-700 transition font-medium hidden"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" id="cancelBtn" class="inline-flex items-center gap-2 px-5 py-2 bg-transparent border-2 border-red-500 text-red-500 hover:bg-red-50 hover:text-red-600 rounded-md transition font-medium hidden"><i class="fas fa-times"></i> Batal</button>
                    <button type="button" id="logoutBtn" class="inline-flex items-center gap-2 px-5 py-2 bg-transparent border-2 border-red-600 text-red-600 rounded-md hover:bg-red-50 hover:text-red-700 transition font-medium"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const logoutBtn = document.getElementById('logoutBtn');
        const form = document.getElementById('profileForm');
        const viewDivs = document.querySelectorAll('.view');
        const editDivs = document.querySelectorAll('.edit');
        const views = document.querySelectorAll('.view p');
        const originalData = views.length >= 5 ? {
            nama: views[0].innerText,
            username: views[1].innerText,
            email: views[2].innerText,
            hp: views[3].innerText,
            alamat: views[4].innerText
        } : {};

        function clearErrors() {
            document.querySelectorAll('.error-text').forEach(el => {
                el.classList.add('hidden');
                el.innerText = '';
            });
        }

        function showErrors(errors) {
            for (let key in errors) {
                let errorDiv = document.getElementById(`error-${key}`);
                if (errorDiv) {
                    errorDiv.innerText = errors[key][0];
                    errorDiv.classList.remove('hidden');
                }
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

        function resetFormToOriginal() {
            document.querySelector('input[name="nama_lengkap"]').value = originalData.nama;
            document.querySelector('input[name="username"]').value = originalData.username;
            document.querySelector('input[name="email"]').value = originalData.email;
            document.querySelector('input[name="no_hp"]').value = originalData.hp;
            document.querySelector('textarea[name="alamat"]').value = originalData.alamat;
            document.getElementById('password').value = '';
        }

        editBtn.addEventListener('click', function() {
            viewDivs.forEach(d => d.classList.add('hidden'));
            editDivs.forEach(d => d.classList.remove('hidden'));
            editBtn.classList.add('hidden');
            saveBtn.classList.remove('hidden');
            cancelBtn.classList.remove('hidden');
            logoutBtn.classList.add('hidden');
            clearErrors();
        });

        cancelBtn.addEventListener('click', function() {
            viewDivs.forEach(d => d.classList.remove('hidden'));
            editDivs.forEach(d => d.classList.add('hidden'));
            editBtn.classList.remove('hidden');
            saveBtn.classList.add('hidden');
            cancelBtn.classList.add('hidden');
            logoutBtn.classList.remove('hidden');
            clearErrors();
            resetFormToOriginal();
        });

        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearErrors();
            const formData = new FormData(form);
            fetch('{{ route("customer.profile.update") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof showLightboxCustom === 'function') {
                        showLightboxCustom(data.message, 'success', () => location.reload());
                    } else if (typeof showLightbox === 'function') {
                        showLightbox(data.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        alert(data.message);
                        location.reload();
                    }
                } else {
                    let hasEmpty = false, hasInvalid = false;
                    for (let key in data.errors) {
                        let errMsg = data.errors[key][0];
                        if (errMsg.includes('harus diisi') || errMsg.includes('wajib diisi')) hasEmpty = true;
                        if (errMsg.includes('domain') || errMsg.includes('minimal') || errMsg.includes('terdiri dari') || errMsg.includes('sudah digunakan')) hasInvalid = true;
                    }
                    let message = hasInvalid ? 'Data tidak sesuai, harap isi kembali.' : 'Harap isi data dengan lengkap';
                    showLightboxAndThen(message, () => {
                        showErrors(data.errors);
                        const firstError = document.querySelector('.error-text:not(.hidden)');
                        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                }
            })
            .catch(() => {
                if (typeof showLightbox === 'function') {
                    showLightbox('Terjadi kesalahan. Silakan coba lagi', 'error');
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        logoutBtn.addEventListener('click', function() {
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
    })();
</script>

@endsection
