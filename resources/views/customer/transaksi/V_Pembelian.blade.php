@extends('layouts.V_Auth')

@section('title', 'Pembelian Produk - SIMBRO')

@section('content')

<div class="min-h-screen bg-white">
    <div class="bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-12 w-auto">
                <div>
                    <h1 class="text-2xl font-bold">Pembelian Produk</h1>
                    <p class="text-orange-100 text-sm">Lengkapi data di bawah untuk melakukan pembelian</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <a href="{{ route('customer.home') }}" class="inline-flex items-center gap-2 text-white hover:underline transition text-sm font-bold"> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex items-center gap-4 bg-gradient-to-r from-orange-50 to-white border border-orange-100 px-6 py-4 rounded-2xl shadow-sm mb-6">
            <div class="bg-[#FF6B00] text-white w-10 h-10 rounded-xl flex items-center justify-center shadow-md">
                <i class="far fa-calendar-alt text-lg"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Informasi Transaksi</p>
                <p class="text-gray-800 font-bold">Waktu pemesanan akan tercatat dilakukan pada: <span class="text-[#FF6B00]">{{ now()->format('d F Y') }}</span></p>
            </div>
        </div>
        {{-- Semua Card Informasi & Syarat --}}
        <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 mb-8 bg-white shadow-sm">
            @foreach($informasis as $index => $info)
                @php
                    $isSyarat = str_contains($info->judul, 'Syarat') || str_contains($info->judul, 'Ketentuan');
                    $isPembayaran = str_contains($info->judul, 'Informasi Pembayaran') || str_contains($info->judul, 'Pembayaran');
                    if ($isPembayaran) {
                        $iconClass = 'fa-info-circle';
                    } elseif ($isSyarat) {
                        $iconClass = 'fa-file-contract';
                    } else {
                        $iconClass = 'fa-bullhorn';
                    }
                @endphp
                <div class="{{ !$loop->first ? 'border-t border-gray-200 pt-4 mt-4' : '' }}">
                    <div class="flex justify-between items-center {{ $isSyarat ? 'cursor-pointer' : '' }}"
                        onclick="{{ $isSyarat ? "toggleAccordion(this)" : '' }}"
                        data-target="accordion-{{ $index }}">
                        <h3 class="text-md font-bold text-gray-700 flex items-center gap-2">
                            <i class="fas {{ $iconClass }} text-[#FF6B00]"></i>
                            {{ $info->judul }}
                        </h3>
                        @if($isSyarat)
                            <i id="icon-{{ $index }}" class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                        @endif
                    </div>
                    <div id="accordion-{{ $index }}"
                        class="mt-2 {{ $isSyarat ? 'accordion-content' : '' }}">
                        <div class="ck-content bg-gray-50 p-4 rounded-xl text-gray-700 text-sm leading-relaxed">
                            {!! $info->deskripsi !!}
                        </div>
                    </div>
                </div>
            @endforeach
            @php
                $firstInfo = $informasis->first();
                $rekeningList = $firstInfo ? $firstInfo->rekening : collect();
            @endphp
            @if($rekeningList->count())
            {{-- Pilihan Rekening Bank --}}
            <div class="border-t border-gray-200 pt-4 mt-4" id="rekeningSection">
                <h3 class="text-md font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-university text-[#FF6B00]"></i> Pilih Rekening Tujuan
                </h3>
                <div class="space-y-2" id="rekeningContainer">
                    @foreach($rekeningList as $rek)
                    <label class="rekening-radio rekening-item">
                        <input type="radio" name="rekening_id" value="{{ $rek->rekening_id }}" {{ $loop->first ? 'checked' : '' }}>
                        <div class="flex-1">
                            <span class="font-semibold text-gray-800">{{ $rek->nama_bank }}</span> -
                            <span class="font-mono text-gray-700">{{ $rek->nomor_rekening }}</span><br>
                            <span class="text-xs text-gray-500">a.n. {{ $rek->pemilik_rekening }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            {{-- Card Detail Produk --}}
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden border border-gray-100 card-produk">
                <div class="relative w-full bg-gray-50 overflow-hidden group" style="height: 320px;">
                    @if($produk->foto)
                        <img src="{{ Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-image text-4xl mb-2 text-gray-300"></i>
                            <span class="text-sm font-medium">Belum ada foto</span>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-gray-700 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm border border-gray-200">
                        ID: {{ $produk->produk_id }}
                    </div>
                    <div class="absolute top-4 right-4 bg-[#FF6B00]/95 backdrop-blur-sm text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-md flex items-center gap-2">
                        <i class="fas fa-box-open text-xs"></i> Stok: {{ $produk->stok }} {{ $produk->kategori == 'Bibit Ayam Broiler' ? 'ekor' : 'kg' }}
                    </div>
                </div>
                <div class="p-6 md:p-8">
                    <div class="mb-6">
                        <h3 class="text-2xl font-extrabold text-gray-800 leading-tight mb-2">{{ $produk->nama_produk }}</h3>
                        <div class="flex items-baseline gap-2">
                            <p class="text-3xl font-black text-[#FF6B00] tracking-tight">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                            <span class="text-sm font-semibold text-gray-500">/ {{ $produk->kategori == 'Bibit Ayam Broiler' ? 'ekor' : 'kg' }}</span>
                        </div>
                    </div>
                    <div class="w-full h-px bg-gray-100 mb-4"></div>
                    <div class="space-y-5 mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center flex-shrink-0 text-[#FF6B00] shadow-sm">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Kategori</p>
                                <p class="text-gray-800 font-bold">{{ $produk->kategori }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center flex-shrink-0 text-[#FF6B00] shadow-sm">
                                <i class="fas fa-align-left"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Deskripsi</p>
                                <p class="text-gray-600 leading-relaxed text-sm">{{ $produk->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-500">
                            <i class="fas fa-building text-[#FF6B00] text-sm"></i>
                            <span class="text-xs font-medium">CV. Mitra Gemuk Bersama</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                {{-- Form Checkout --}}
                <div id="checkoutFormContainer" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    @php
                        $minPembelian = ($produk->kategori == 'Bibit Ayam Broiler') ? 60 : 2;
                        $satuan = ($produk->kategori == 'Bibit Ayam Broiler') ? 'ekor' : 'kg';
                    @endphp
                    <div class="mb-4 flex items-center gap-2 text-sm text-gray-600 bg-gray-50 p-3 rounded-xl">
                        <i class="fas fa-info-circle text-[#FF6B00]"></i>
                        <span><span class="font-semibold">Minimal pembelian:</span> {{ $minPembelian }} {{ $satuan }}</span>
                    </div>
                    <div id="checkoutContent">
                        <div class="mb-5">
                            <label class="block font-semibold text-gray-700 mb-2">Jumlah</label>
                            <div class="flex items-center gap-3" id="jumlahWrapper">
                                <div class="flex border rounded-lg shadow-sm overflow-hidden">
                                    <button type="button" id="kurang" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition text-gray-700 font-medium">-</button>
                                    <input type="number" name="jumlah" id="jumlah" value="{{ $minPembelian }}" min="{{ $minPembelian }}" max="{{ $produk->stok }}" class="w-20 text-center border-x py-2 no-spinner focus:outline-none">
                                    <button type="button" id="tambah" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition text-gray-700 font-medium">+</button>
                                </div>
                                <span id="totalHarga" class="text-xl font-bold text-[#FF6B00] total-harga-text">Rp{{ number_format($produk->harga * $minPembelian, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="block font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                            <div class="relative">
                                <select name="metode_pembayaran" id="metode_pembayaran" class="w-full border rounded-lg px-4 py-2.5 appearance-none bg-white pr-10 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] transition">
                                    <option value="Transfer Bank">Transfer Bank</option>
                                    <option value="E-Wallet">E-Wallet</option>
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="btnCheckout" class="w-full bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-cart"></i> Checkout
                        </button>
                    </div>
                </div>

                {{-- Form Upload Bukti --}}
                <div id="uploadSection" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 opacity-50 pointer-events-none transition">
                    <div class="mb-3 p-3 bg-blue-50 rounded-lg text-sm text-blue-700">
                        <i class="fas fa-info-circle"></i> Silakan transfer sesuai total harga ke rekening tujuan yang dipilih, lalu upload bukti.
                    </div>
                    <label class="block font-semibold text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG (MAX 2MB)</p>
                            </div>
                            <input type="file" id="buktiFile" accept="image/*" class="hidden">
                        </label>
                    </div>
                    <div id="linkBuktiContainer" class="text-center hidden">
                        <a id="buktiLink" href="#" target="_blank" class="link-bukti">
                            <i class="fas fa-eye"></i> Lihat Bukti Pembayaran
                        </a>
                    </div>
                    <button id="btnKirim" class="mt-4 w-full bg-gray-400 text-white font-semibold py-2 rounded-xl transition cursor-not-allowed flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Bukti
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle accordion untuk card syarat & ketentuan
    function toggleAccordion(header) {
        const targetId = header.getAttribute('data-target');
        const content = document.getElementById(targetId);
        const icon = header.querySelector('.fa-chevron-down, .fa-chevron-up');
        if (content && icon) {
            content.classList.toggle('open');
            if (content.classList.contains('open')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }
    }

    // Fungsi scroll ke card produk
    function scrollToProduk() {
        const produkElement = document.querySelector('.card-produk');
        if (produkElement) {
            produkElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    const hargaSatuan = {{ $produk->harga }};
    const stok = {{ $produk->stok }};
    const minimal = {{ ($produk->kategori == 'Bibit Ayam Broiler') ? 60 : 2 }};
    const jumlahInput = document.getElementById('jumlah');
    const totalSpan = document.getElementById('totalHarga');
    const btnCheckout = document.getElementById('btnCheckout');
    const uploadSection = document.getElementById('uploadSection');
    const btnKirim = document.getElementById('btnKirim');
    const buktiFile = document.getElementById('buktiFile');
    const linkBuktiContainer = document.getElementById('linkBuktiContainer');
    const buktiLink = document.getElementById('buktiLink');
    const btnKurang = document.getElementById('kurang');
    const btnTambah = document.getElementById('tambah');
    const metodeSelect = document.getElementById('metode_pembayaran');
    const rekeningRadios = document.querySelectorAll('input[name="rekening_id"]');
    const jumlahWrapper = document.getElementById('jumlahWrapper');

    function updateTotal() {
        let jumlah = parseInt(jumlahInput.value) || minimal;
        if (jumlah < minimal) jumlah = minimal;
        if (jumlah > stok) jumlah = stok;
        jumlahInput.value = jumlah;
        let total = hargaSatuan * jumlah;
        totalSpan.innerText = 'Rp' + total.toLocaleString('id-ID');
    }

    function resetCheckoutForm() {
        jumlahInput.value = minimal;
        updateTotal();
        metodeSelect.value = 'Transfer Bank';
        if (rekeningRadios.length) rekeningRadios[0].checked = true;
        jumlahInput.disabled = false;
        btnKurang.disabled = false;
        btnTambah.disabled = false;
        metodeSelect.disabled = false;
        rekeningRadios.forEach(r => r.disabled = false);
        jumlahWrapper.classList.remove('disabled-blur');
        totalSpan.classList.remove('text-gray-400');
        totalSpan.classList.add('text-[#FF6B00]');
        btnCheckout.innerHTML = '<i class="fas fa-shopping-cart"></i> Checkout';
        btnCheckout.classList.remove('bg-red-500', 'hover:bg-red-600');
        btnCheckout.classList.add('bg-[#FF6B00]', 'hover:bg-orange-700');
        btnCheckout.onclick = checkoutHandler;
        uploadSection.classList.add('opacity-50', 'pointer-events-none');
        btnKirim.classList.remove('bg-[#FF6B00]', 'cursor-pointer', 'hover:bg-orange-700');
        btnKirim.classList.add('bg-gray-400', 'cursor-not-allowed');
        buktiFile.value = '';
        linkBuktiContainer.classList.add('hidden');
        buktiLink.href = '#';
        fetch('{{ route("customer.transaksi.clear") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).catch(e => console.log);
    }

    function checkoutHandler() {
        let rekeningId = document.querySelector('input[name="rekening_id"]:checked')?.value;
        if (!rekeningId) {
            if (typeof showLightbox === 'function') showLightbox('Silakan pilih rekening tujuan terlebih dahulu.', 'error');
            else alert('Silakan pilih rekening tujuan terlebih dahulu.');
            return;
        }
        const confirmAction = () => {
            const formData = new FormData();
            formData.append('jumlah', jumlahInput.value);
            formData.append('metode_pembayaran', metodeSelect.value);
            formData.append('rekening_id', rekeningId);
            fetch('{{ route("customer.transaksi.prepare", $produk->produk_id) }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    jumlahInput.disabled = true;
                    btnKurang.disabled = true;
                    btnTambah.disabled = true;
                    metodeSelect.disabled = true;
                    rekeningRadios.forEach(r => r.disabled = true);
                    jumlahWrapper.classList.add('disabled-blur');
                    totalSpan.classList.remove('text-[#FF6B00]');
                    totalSpan.classList.add('text-gray-400');
                    btnCheckout.innerHTML = '<i class="fas fa-times-circle"></i> Batalkan Checkout';
                    btnCheckout.classList.remove('bg-[#FF6B00]', 'hover:bg-orange-700');
                    btnCheckout.classList.add('bg-red-500', 'hover:bg-red-600');
                    btnCheckout.onclick = () => {
                        if (typeof showConfirm === 'function') {
                            showConfirm('Batalkan proses checkout? Data yang belum disimpan akan hilang.', () => {
                                resetCheckoutForm();
                            });
                        } else {
                            if (confirm('Batalkan proses checkout? Data yang belum disimpan akan hilang.')) resetCheckoutForm();
                        }
                    };
                    uploadSection.classList.remove('opacity-50', 'pointer-events-none');
                    btnKirim.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    btnKirim.classList.add('bg-[#FF6B00]', 'cursor-pointer', 'hover:bg-orange-700');
                    if (typeof showLightbox === 'function') showLightbox(data.message, 'success');
                } else {
                    if (typeof showLightbox === 'function') {
                        showLightbox(data.message, 'error');
                        setTimeout(() => scrollToProduk(), 1000);
                    } else {
                        alert(data.message);
                        scrollToProduk();
                    }
                }
            })
            .catch(() => {
                if (typeof showLightbox === 'function') {
                    showLightbox('Terjadi kesalahan saat checkout', 'error');
                    setTimeout(() => scrollToProduk(), 1000);
                } else {
                    alert('Terjadi kesalahan');
                    scrollToProduk();
                }
            });
        };
        if (typeof showConfirm === 'function') {
            showConfirm('Apakah anda yakin ingin melanjutkan transaksi?', confirmAction);
        } else {
            if (confirm('Apakah anda yakin ingin melanjutkan transaksi?')) confirmAction();
        }
    }
    btnCheckout.onclick = checkoutHandler;

    document.getElementById('tambah').addEventListener('click', () => {
        if (!jumlahInput.disabled) {
            let val = parseInt(jumlahInput.value);
            if (val < stok) jumlahInput.value = val + 1;
            updateTotal();
        }
    });
    document.getElementById('kurang').addEventListener('click', () => {
        if (!jumlahInput.disabled) {
            let val = parseInt(jumlahInput.value);
            if (val > minimal) jumlahInput.value = val - 1;
            updateTotal();
        }
    });
    jumlahInput.addEventListener('input', updateTotal);
    updateTotal();

    buktiFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (!file.type.match('image.*')) {
                if (typeof showLightbox === 'function') showLightbox('File harus gambar', 'error');
                else alert('File harus gambar');
                buktiFile.value = '';
                linkBuktiContainer.classList.add('hidden');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                if (typeof showLightbox === 'function') showLightbox('Ukuran maksimal 2MB', 'error');
                else alert('Ukuran maksimal 2MB');
                buktiFile.value = '';
                linkBuktiContainer.classList.add('hidden');
                return;
            }
            const objectUrl = URL.createObjectURL(file);
            buktiLink.href = objectUrl;
            linkBuktiContainer.classList.remove('hidden');
        } else {
            linkBuktiContainer.classList.add('hidden');
            buktiLink.href = '#';
        }
    });

    btnKirim.addEventListener('click', function() {
        if (!buktiFile.files.length) {
            if (typeof showLightbox === 'function') {
                showLightbox('Harap pilih file bukti pembayaran', 'error');
                setTimeout(() => scrollToProduk(), 1000);
            } else {
                alert('Harap pilih file bukti pembayaran');
                scrollToProduk();
            }
            return;
        }
        const formData = new FormData();
        formData.append('bukti_pembayaran', buktiFile.files[0]);
        fetch('{{ route("customer.transaksi.store") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof showLightbox === 'function') {
                    showLightbox(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("customer.riwayat.transaksi") }}';
                    }, 1500);
                } else {
                    alert(data.message);
                    window.location.href = '{{ route("customer.riwayat.transaksi") }}';
                }
            } else {
                if (typeof showLightbox === 'function') {
                    showLightbox(data.message, 'error');
                    setTimeout(() => scrollToProduk(), 1000);
                } else {
                    alert(data.message);
                    scrollToProduk();
                }
            }
        })
        .catch(() => {
            if (typeof showLightbox === 'function') {
                showLightbox('Terjadi kesalahan saat upload bukti', 'error');
                setTimeout(() => scrollToProduk(), 1000);
            } else {
                alert('Terjadi kesalahan');
                scrollToProduk();
            }
        });
    });
</script>
@endsection
