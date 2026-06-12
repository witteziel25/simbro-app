@extends('layouts.V_Auth')

@section('title', 'Tambah Produk')

@section('header_title', 'Tambah Produk')
@section('header_desc', 'Lengkapi data produk untuk menambahkannya ke katalog. Pastikan semua field terisi dengan benar. Stok & harga harus positif.')
@section('header_back_url', route('admin.home') . '#produk')
@section('header_back_text', 'Kembali ke Daftar Produk')

@section('content')

<div class="flex-1 flex flex-col bg-white">
    <div class="flex-1 p-6 md:p-12 overflow-y-auto bg-gray-50/30 flex items-center">
        <div class="max-w-4xl w-full mx-auto card-form p-8">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[#FF6B00] pl-3">Form Tambah Produk</h2>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-5 text-sm rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="tambahProdukForm" action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                        <div id="error-nama" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" id="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                            <option value="">Pilih Kategori</option>
                            <option value="Bibit Ayam Broiler" {{ old('kategori') == 'Bibit Ayam Broiler' ? 'selected' : '' }}>Bibit Ayam Broiler</option>
                            <option value="Ayam Broiler Dewasa" {{ old('kategori') == 'Ayam Broiler Dewasa' ? 'selected' : '' }}>Ayam Broiler Dewasa</option>
                        </select>
                        <div id="error-kategori" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp) / ekor / kg</label>
                        <input type="number" name="harga" id="harga" value="{{ old('harga') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                        <div id="error-harga" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Stok (ekor / kg)</label>
                        <input type="number" name="stok" id="stok" value="{{ old('stok') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                        <div id="error-stok" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">{{ old('deskripsi') }}</textarea>
                        <div id="error-deskripsi" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Produk</label>
                        <input type="file" name="foto" id="foto" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">
                        <div id="error-foto" class="error-text text-red-500 text-xs mt-1 hidden"></div>
                        <p class="text-xs text-gray-500 mt-1">Wajib diisi (max 2MB, jpg/png)</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.home') }}#produk" class="inline-flex items-center gap-2 px-5 py-2 bg-transparent border-2 border-red-500 text-red-500 hover:bg-red-50 hover:text-red-600 rounded-md transition font-medium">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" id="submitBtn" class="inline-flex items-center gap-2 px-5 py-2 btn-orange rounded-md hover:bg-orange-700 transition font-medium">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        const form = document.getElementById('tambahProdukForm');
        const nama = document.getElementById('nama_produk');
        const kategori = document.getElementById('kategori');
        const harga = document.getElementById('harga');
        const stok = document.getElementById('stok');
        const deskripsi = document.getElementById('deskripsi');
        const foto = document.getElementById('foto');

        const errorNama = document.getElementById('error-nama');
        const errorKategori = document.getElementById('error-kategori');
        const errorHarga = document.getElementById('error-harga');
        const errorStok = document.getElementById('error-stok');
        const errorDeskripsi = document.getElementById('error-deskripsi');
        const errorFoto = document.getElementById('error-foto');



        function clearErrors() {
            [errorNama, errorKategori, errorHarga, errorStok, errorDeskripsi, errorFoto].forEach(el => el.classList.add('hidden'));
        }

        function showErrors(errors) {
            if (errors.nama) { errorNama.innerText = errors.nama; errorNama.classList.remove('hidden'); }
            if (errors.kategori) { errorKategori.innerText = errors.kategori; errorKategori.classList.remove('hidden'); }
            if (errors.harga) { errorHarga.innerText = errors.harga; errorHarga.classList.remove('hidden'); }
            if (errors.stok) { errorStok.innerText = errors.stok; errorStok.classList.remove('hidden'); }
            if (errors.deskripsi) { errorDeskripsi.innerText = errors.deskripsi; errorDeskripsi.classList.remove('hidden'); }
            if (errors.foto) { errorFoto.innerText = errors.foto; errorFoto.classList.remove('hidden'); }
            const first = document.querySelector('.error-text:not(.hidden)');
            if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function validate() {
            const errors = {};
            let hasEmpty = false, hasInvalid = false;

            if (nama.value.trim() === '') { errors.nama = 'Nama produk harus diisi'; hasEmpty = true; }
            if (kategori.value === '') { errors.kategori = 'Pilih salah satu kategori produk'; hasEmpty = true; }
            if (harga.value === '') { errors.harga = 'Harga produk harus diisi'; hasEmpty = true; }
            else if (parseFloat(harga.value) < 0) { errors.harga = 'Harga minimal adalah 0'; hasInvalid = true; }
            if (stok.value === '') { errors.stok = 'Stok produk harus diisi'; hasEmpty = true; }
            else if (parseInt(stok.value) < 0) { errors.stok = 'Stok minimal adalah 0'; hasInvalid = true; }
            if (deskripsi.value.trim() === '') { errors.deskripsi = 'Deskripsi produk harus diisi'; hasEmpty = true; }
            if (foto.files.length === 0) { errors.foto = 'Foto produk harus dimuat'; hasEmpty = true; }

            if (Object.keys(errors).length === 0) return null;
            let message = hasInvalid ? 'Data tidak sesuai, silahkan isi kembali.' : 'Harap isi data dengan lengkap';
            return { message, errors };
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const validation = validate();
            if (!validation) {
                form.submit();
                return;
            }
            pendingErrors = validation.errors;
            showLightboxAndThen(validation.message, () => {
                clearErrors();
                showErrors(pendingErrors);
                pendingErrors = null;
            });
        });
    })();
</script>

@endsection
