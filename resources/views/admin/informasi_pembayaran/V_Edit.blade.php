@extends('layouts.V_Auth')

@section('title', 'Edit Card Informasi - SIMBRO Admin')

@section('header_title', 'Edit Informasi')
@section('header_desc', 'Ubah judul dan deskripsi informasi yang sudah ada')
@section('header_back_url', route('admin.informasi-pembayaran'))
@section('header_back_text', 'Kembali ke Info. Pembayaran')

@section('content')
<style>
    .error-text {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 4px;
        display: block;
    }
    .ck-content ul, .ck-content ol {
        list-style: revert !important;
        padding-left: 2rem !important;
        margin: 0.5rem 0 !important;
    }
    .ck-content h1, .ck-content h2, .ck-content h3 {
        font-size: revert;
        font-weight: revert;
    }
    .ck-content p {
        margin: 0 0 0.5rem 0;
    }
</style>

<div class="flex-1 flex flex-col bg-white">
    <div class="flex-1 bg-white p-6 md:p-10 flex items-center">
        <div class="max-w-4xl w-full mx-auto">
            <div class="card-form p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-5 border-l-4 border-[#FF6B00] pl-3">Edit Informasi</h2>
                <form method="POST" action="{{ route('admin.informasi-pembayaran.update', $informasi->informasi_id) }}" id="formInformasi" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 mb-2">Judul</label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul', $informasi->judul) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#FF6B00] focus:border-[#FF6B00]">
                        <div id="error-judul" class="error-text"></div>
                        @error('judul')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="editor" rows="12" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('deskripsi', $informasi->deskripsi) }}</textarea>
                        <div id="error-deskripsi" class="error-text"></div>
                        @error('deskripsi')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.informasi-pembayaran') }}" class="bg-transparent border-2 border-red-600 text-red-600 hover:bg-red-50 hover:text-red-700 px-5 py-2 rounded-md font-semibold transition flex items-center gap-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" id="submitBtn" class="btn-orange px-5 py-2 rounded-md font-semibold shadow-sm transition flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    let editorInstance;

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

    function clearErrors() {
        document.getElementById('error-judul').innerText = '';
        document.getElementById('error-deskripsi').innerText = '';
    }

    function showErrors(errors) {
        if (errors.judul) document.getElementById('error-judul').innerText = errors.judul;
        if (errors.deskripsi) document.getElementById('error-deskripsi').innerText = errors.deskripsi;
        const firstError = document.querySelector('.error-text');
        if (firstError && firstError.innerText) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function validate() {
        const errors = {};
        const judul = document.getElementById('judul').value.trim();
        if (!judul) errors.judul = 'Judul informasi harus diisi';

        let deskripsiText = '';
        if (editorInstance) {
            const div = document.createElement('div');
            div.innerHTML = editorInstance.getData();
            deskripsiText = div.textContent || div.innerText || '';
        }
        if (!deskripsiText.trim()) errors.deskripsi = 'Deskripsi informasi harus diisi';

        if (Object.keys(errors).length === 0) return null;
        return { message: 'Harap isi data dengan lengkap', errors };
    }

    ClassicEditor.create(document.querySelector('#editor'), {
        toolbar: ['heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'alignment', 'undo', 'redo'],
        alignment: { options: ['left', 'center', 'right', 'justify'] }
    }).then(editor => {
        editorInstance = editor;
    }).catch(err => console.error(err));

    document.getElementById('formInformasi').addEventListener('submit', function(e) {
        e.preventDefault();
        const validation = validate();
        if (!validation) {
            this.submit();
            return;
        }
        showLightboxAndThen(validation.message, () => {
            clearErrors();
            showErrors(validation.errors);
        });
    });
</script>
@endsection
