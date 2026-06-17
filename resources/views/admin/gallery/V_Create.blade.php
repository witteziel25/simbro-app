@extends('layouts.V_Auth')

@section('title', 'Tambah Konten Gallery - SIMBRO Admin')

@section('header_title', 'Tambah Konten Gallery')
@section('header_desc', 'Unggah gambar dan tulis judul, keterangan, serta artikel')
@section('header_back_url', url()->previous())
@section('header_back_text', 'Kembali ke Gallery')

@section('content')

<div class="flex-1 bg-white">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" id="formGallery" novalidate>
            @csrf
            <div class="card-form p-6 space-y-6">
                <h2 class="text-xl font-bold text-gray-800 mb-5 border-l-4 border-[#FF6B00] pl-3">Buat Konten Gallery Baru</h2>
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <div id="error-gambar" class="error-text"></div>
                    <p class="error-text" style="color: #6b7280;">Maksimal ukuran 5 MB (jpeg, png, jpg)</p>
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Judul <span class="text-sm font-normal text-gray-500">(maksimal 50 karakter)</span></label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <div class="flex justify-between items-center mt-1">
                        <div id="error-judul" class="error-text"></div>
                        <span id="judul-counter" class="char-counter text-gray-500">0 / 50 karakter</span>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Keterangan <span class="text-sm font-normal text-gray-500">(maksimal 255 karakter)</span></label>
                    <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <div class="flex justify-between items-center mt-1">
                        <div id="error-keterangan" class="error-text"></div>
                        <span id="keterangan-counter" class="char-counter text-gray-500">0 / 255 karakter</span>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Artikel (detail) <span class="text-sm font-normal text-gray-500">Maksimal 2000 karakter, termasuk spasi</span></label>
                    <textarea name="artikel" id="editor" rows="10" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('artikel') }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        <div id="error-artikel" class="error-text"></div>
                        <span id="charCounter" class="text-sm text-gray-500">0 / 2000 karakter</span>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.home', ['#gallery']) }}" class="inline-flex items-center gap-2 bg-transparent border-2 border-red-500 text-red-500 hover:bg-red-50 hover:text-red-600 font-bold px-5 py-2 rounded-md transition">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" id="submitBtn" class="inline-flex items-center gap-2 btn-orange font-bold px-5 py-2 rounded-md transition">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    const MAX_JUDUL = 50;
    const MAX_KETERANGAN = 255;
    const MAX_ARTIKEL = 2000;

    const judulInput = document.getElementById('judul');
    const keteranganInput = document.getElementById('keterangan');
    const judulCounter = document.getElementById('judul-counter');
    const keteranganCounter = document.getElementById('keterangan-counter');
    const submitBtn = document.getElementById('submitBtn');
    const errorJudul = document.getElementById('error-judul');
    const errorKeterangan = document.getElementById('error-keterangan');
    const gambarInput = document.getElementById('gambar');
    const errorGambar = document.getElementById('error-gambar');

    function updateJudulCounter() {
        const len = judulInput.value.length;
        judulCounter.innerText = `${len} / ${MAX_JUDUL} karakter`;
        if (len > MAX_JUDUL) {
            judulCounter.classList.add('counter-error');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            errorJudul.innerText = `Jumlah karakter maksimal adalah ${MAX_JUDUL} karakter (kelebihan ${len - MAX_JUDUL} karakter)`;
            errorJudul.style.display = 'block';
        } else {
            judulCounter.classList.remove('counter-error');
            errorJudul.style.display = 'none';
        }
        checkSubmitEnable();
    }

    function updateKeteranganCounter() {
        const len = keteranganInput.value.length;
        keteranganCounter.innerText = `${len} / ${MAX_KETERANGAN} karakter`;
        if (len > MAX_KETERANGAN) {
            keteranganCounter.classList.add('counter-error');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            errorKeterangan.innerText = `Jumlah karakter maksimal adalah ${MAX_KETERANGAN} karakter (kelebihan ${len - MAX_KETERANGAN} karakter)`;
            errorKeterangan.style.display = 'block';
        } else {
            keteranganCounter.classList.remove('counter-error');
            errorKeterangan.style.display = 'none';
        }
        checkSubmitEnable();
    }

    function checkSubmitEnable() {
        if (judulInput.value.length > MAX_JUDUL || keteranganInput.value.length > MAX_KETERANGAN) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }
    }

    judulInput.addEventListener('input', updateJudulCounter);
    keteranganInput.addEventListener('input', updateKeteranganCounter);

    function showLightboxCustom(message, type, callback) {
        if (typeof showLightbox === 'function') {
            showLightbox(message, type);
            if (callback) {
                const interval = setInterval(() => {
                    const modal = document.getElementById('lightboxModal');
                    if (modal && modal.classList.contains('invisible')) {
                        clearInterval(interval);
                        callback();
                    }
                }, 100);
            }
        } else {
            alert(message);
            if (callback) callback();
        }
    }

    function clearErrors() {
        document.querySelectorAll('.error-text').forEach(el => {
            el.innerText = '';
            el.style.display = 'none';
        });
    }

    function showErrors(errors) {
        if (errors.gambar) { errorGambar.innerText = errors.gambar; errorGambar.style.display = 'block'; }
        if (errors.judul) { errorJudul.innerText = errors.judul; errorJudul.style.display = 'block'; }
        if (errors.keterangan) { errorKeterangan.innerText = errors.keterangan; errorKeterangan.style.display = 'block'; }
        if (errors.artikel) { document.getElementById('error-artikel').innerText = errors.artikel; document.getElementById('error-artikel').style.display = 'block'; }
        const first = document.querySelector('.error-text[style*="display: block"]');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function validate() {
        const errors = {};
        let hasEmpty = false;
        let hasImageError = false;
        let hasMaxError = false;

        // Gambar (wajib untuk create)
        const gambar = gambarInput.files[0];
        if (!gambar) {
            errors.gambar = 'Belum ada gambar yang dimuat';
            hasEmpty = true;
        } else {
            if (gambar.size > 5 * 1024 * 1024) {
                errors.gambar = 'Ukuran gambar maksimal 5 MB';
                hasImageError = true;
            }
            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(gambar.type)) {
                errors.gambar = 'Format gambar harus jpeg, png, atau jpg';
                hasImageError = true;
            }
        }

        const judul = judulInput.value.trim();
        if (!judul) {
            errors.judul = 'Judul harus diisi';
            hasEmpty = true;
        } else if (judul.length > MAX_JUDUL) {
            errors.judul = `Jumlah karakter maksimal adalah ${MAX_JUDUL} karakter`;
            hasMaxError = true;
        }

        const keterangan = keteranganInput.value.trim();
        if (!keterangan) {
            errors.keterangan = 'Keterangan harus diisi';
            hasEmpty = true;
        } else if (keterangan.length > MAX_KETERANGAN) {
            errors.keterangan = `Jumlah karakter maksimal adalah ${MAX_KETERANGAN} karakter`;
            hasMaxError = true;
        }

        let artikelText = '';
        if (editorInstance) {
            const div = document.createElement('div');
            div.innerHTML = editorInstance.getData();
            artikelText = div.textContent || div.innerText || '';
        }
        if (!artikelText.trim()) {
            errors.artikel = 'Isi artikel harus diisi';
            hasEmpty = true;
        } else if (artikelText.length > MAX_ARTIKEL) {
            errors.artikel = `Jumlah karakter maksimal adalah ${MAX_ARTIKEL} karakter (kelebihan ${artikelText.length - MAX_ARTIKEL} karakter)`;
            hasMaxError = true;
        }

        if (Object.keys(errors).length === 0) return null;

        let message = '';
        if (hasImageError) {
            message = 'Harap isi data dengan benar';
        } else if (hasEmpty) {
            message = 'Harap isi data dengan lengkap';
        } else if (hasMaxError) {
            // Hanya error max karakter, tidak perlu lightbox
            return { message: null, errors, onlyMaxError: true };
        } else {
            message = 'Harap isi data dengan benar';
        }
        return { message, errors, onlyMaxError: false };
    }

    // Inisialisasi CKEditor
    ClassicEditor.create(document.querySelector('#editor'), {
        toolbar: ['heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'alignment', 'undo', 'redo'],
        initialData: @json(old('artikel', ''))
    }).then(editor => {
        editorInstance = editor;
        function getPlainLength() {
            const data = editor.getData();
            const div = document.createElement('div');
            div.innerHTML = data;
            return (div.textContent || div.innerText || '').length;
        }
        function updateCounter() {
            const len = getPlainLength();
            const counterSpan = document.getElementById('charCounter');
            const errorSpan = document.getElementById('error-artikel');
            counterSpan.innerText = `${len} / ${MAX_ARTIKEL} karakter`;
            if (len > MAX_ARTIKEL) {
                counterSpan.classList.add('counter-error');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                if (!errorSpan.innerText) {
                    errorSpan.innerText = `Jumlah karakter maksimal adalah ${MAX_ARTIKEL} karakter (kelebihan ${len - MAX_ARTIKEL} karakter)`;
                    errorSpan.style.display = 'block';
                }
            } else {
                counterSpan.classList.remove('counter-error');
                if (judulInput.value.length <= MAX_JUDUL && keteranganInput.value.length <= MAX_KETERANGAN) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
                if (errorSpan.innerText.includes('kelebihan')) {
                    errorSpan.style.display = 'none';
                }
            }
        }
        editor.model.document.on('change:data', updateCounter);
        updateCounter();
        updateJudulCounter();
        updateKeteranganCounter();
    }).catch(err => console.error(err));

    // AJAX submit
    const form = document.getElementById('formGallery');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const validation = validate();
        if (!validation) {
            // Valid, submit via AJAX
            if (editorInstance) {
                document.querySelector('#editor').value = editorInstance.getData();
            }
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan lightbox sukses, lalu redirect ke beranda
                    showLightboxCustom(data.message, 'success', () => {
                        window.location.href = "{{ route('admin.home', ['#gallery']) }}";
                    });
                } else {
                    // Error dari server (validasi server)
                    if (data.errors) {
                        let hasEmpty = false, hasImageError = false;
                        for (let key in data.errors) {
                            let errMsg = data.errors[key][0];
                            if (errMsg.includes('harus diisi') || errMsg.includes('Belum ada gambar')) hasEmpty = true;
                            if (errMsg.includes('maksimal') || errMsg.includes('gambar')) hasImageError = true;
                        }
                        let message = hasImageError ? 'Harap isi data dengan benar' : (hasEmpty ? 'Harap isi data dengan lengkap' : 'Harap isi data dengan benar');
                        showLightboxCustom(message, 'error', () => {
                            clearErrors();
                            for (let key in data.errors) {
                                let errorEl = document.getElementById(`error-${key}`);
                                if (errorEl) {
                                    errorEl.innerText = data.errors[key][0];
                                    errorEl.style.display = 'block';
                                }
                            }
                        });
                    } else {
                        showLightboxCustom(data.message || 'Terjadi kesalahan', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showLightboxCustom('Terjadi kesalahan pada server', 'error');
            });
            return;
        }
        if (validation.onlyMaxError) {
            clearErrors();
            showErrors(validation.errors);
            return;
        }
        // Ada error client-side (kosong atau gambar)
        showLightboxCustom(validation.message, 'error', () => {
            clearErrors();
            showErrors(validation.errors);
        });
    });
</script>
@endsection
