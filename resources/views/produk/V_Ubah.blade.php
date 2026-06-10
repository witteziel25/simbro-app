@extends('layouts.V_Auth')

@section('title', 'Ubah Produk - ' . $produk->nama_produk)

@section('content')

<div class="min-h-screen flex flex-col md:flex-row">
    <div class="w-full md:w-80 bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] flex flex-col justify-center px-10 py-10 text-white">
        <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-28 w-28 mb-6">
        <h1 class="text-3xl font-bold mb-3">Ubah Produk</h1>
        <p class="text-white-100 text-sm mb-4">Perbarui informasi produk yang sudah ada. Pastikan data sesuai dengan stok terbaru.</p>
        <div class="mb-5 mt-3">
            <i class="fas fa-arrow-left"></i> <a href="{{ route('admin.home') }}#produk" class="inline-flex items-center gap-2 text-white hover:underline transition text-l font-bold"> Kembali ke Daftar Produk</a>
        </div>
    </div>

    <div class="flex-1 bg-white p-6 md:p-16 overflow-y-auto">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-xl font-bold text-gray-800 mb-5 border-l-4 border-[#FF6B00] pl-3">Form Ubah Produk</h2>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-5 text-sm rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="updateProdukForm" action="{{ route('produk.update', $produk->produk_id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-semibold text-gray-700 mb-1">ID Produk</label><p class="text-gray-700 bg-gray-100 p-2 rounded-lg">{{ $produk->produk_id }}</p></div>
                    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label><select name="kategori" id="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none"><option value="">Pilih Kategori</option><option value="Bibit Ayam Broiler" {{ old('kategori', $produk->kategori) == 'Bibit Ayam Broiler' ? 'selected' : '' }}>Bibit Ayam Broiler</option><option value="Ayam Broiler Dewasa" {{ old('kategori', $produk->kategori) == 'Ayam Broiler Dewasa' ? 'selected' : '' }}>Ayam Broiler Dewasa</option></select><div id="error-kategori" class="error-text text-red-500 text-xs mt-1 hidden"></div></div>
                    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk</label><input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none"><div id="error-nama" class="error-text text-red-500 text-xs mt-1 hidden"></div></div>
                    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp) / ekor / kg</label><input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none"><div id="error-harga" class="error-text text-red-500 text-xs mt-1 hidden"></div></div>
                    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Stok (ekor / kg)</label><input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none"><div id="error-stok" class="error-text text-red-500 text-xs mt-1 hidden"></div></div>
                    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label><textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none">{{ old('deskripsi', $produk->deskripsi) }}</textarea><div id="error-deskripsi" class="error-text text-red-500 text-xs mt-1 hidden"></div></div>
                    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Foto Produk</label>@if($produk->foto)<div class="mb-2"><img src="{{ Storage::url($produk->foto) }}" class="w-32 rounded-lg border"></div>@endif<input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF6B00] focus:outline-none"><p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto (max 2MB, jpg/png)</p></div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.home') }}#produk" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" id="submitBtn" class="inline-flex items-center gap-2 px-5 py-2 bg-[#FF6B00] text-white rounded-lg hover:bg-orange-700 transition font-medium"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        const form = document.getElementById('updateProdukForm');
        const kategori = document.getElementById('kategori');
        const nama = document.getElementById('nama_produk');
        const harga = document.getElementById('harga');
        const stok = document.getElementById('stok');
        const deskripsi = document.getElementById('deskripsi');
        const errorKategori = document.getElementById('error-kategori');
        const errorNama = document.getElementById('error-nama');
        const errorHarga = document.getElementById('error-harga');
        const errorStok = document.getElementById('error-stok');
        const errorDeskripsi = document.getElementById('error-deskripsi');

        let pendingErrors = null;

        function showLightboxAndThen(message, callback) {
            if (typeof showLightbox === 'function') {
                showLightbox(message, 'error'); // Tipe 'error' akan menampilkan gambar warning
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
            [errorKategori, errorNama, errorHarga, errorStok, errorDeskripsi].forEach(el => el.classList.add('hidden'));
        }

        function showErrors(errors) {
            if (errors.kategori) { errorKategori.innerText = errors.kategori; errorKategori.classList.remove('hidden'); }
            if (errors.nama) { errorNama.innerText = errors.nama; errorNama.classList.remove('hidden'); }
            if (errors.harga) { errorHarga.innerText = errors.harga; errorHarga.classList.remove('hidden'); }
            if (errors.stok) { errorStok.innerText = errors.stok; errorStok.classList.remove('hidden'); }
            if (errors.deskripsi) { errorDeskripsi.innerText = errors.deskripsi; errorDeskripsi.classList.remove('hidden'); }
            const first = document.querySelector('.error-text:not(.hidden)');
            if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function validate() {
            const errors = {};
            let hasEmpty = false, hasInvalid = false;
            if (kategori.value === '') { errors.kategori = 'Pilih salah satu kategori produk'; hasEmpty = true; }
            if (nama.value.trim() === '') { errors.nama = 'Nama produk harus diisi'; hasEmpty = true; }
            if (harga.value === '') { errors.harga = 'Harga produk harus diisi'; hasEmpty = true; }
            else if (parseFloat(harga.value) < 0) { errors.harga = 'Harga minimal adalah 0'; hasInvalid = true; }
            if (stok.value === '') { errors.stok = 'Stok produk harus diisi'; hasEmpty = true; }
            else if (parseInt(stok.value) < 0) { errors.stok = 'Stok minimal adalah 0'; hasInvalid = true; }
            if (deskripsi.value.trim() === '') { errors.deskripsi = 'Deskripsi produk harus diisi'; hasEmpty = true; }

            if (Object.keys(errors).length === 0) return null;
            let message = hasInvalid ? 'Data tidak sesuai, silahkan isi kembali.' : 'Harap isi data dengan lengkap';
            return { message, errors };
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const validation = validate();
            if (!validation) { form.submit(); return; }
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
