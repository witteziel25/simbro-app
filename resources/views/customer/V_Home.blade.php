@extends('layouts.app')

@section('title', 'Beranda - SIMBRO')

@section('content')

<!-- SECTION GALLERY - Versi Customer (tanpa tombol tambah) -->
<section id="gallery" class="relative w-full h-screen overflow-hidden">
    <div class="gallery-container relative w-full h-full">
        <div class="gallery-track flex h-full transition-transform duration-700 ease-out">
            @forelse($slides as $slide)
            <div class="gallery-slide flex-shrink-0 w-full h-full relative">
                <img src="{{ Storage::url($slide->gambar) }}" alt="{{ $slide->judul }}" class="w-full h-full object-cover transition-transform duration-5000 ease-out">
                <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-black/80"></div>
                <div class="absolute inset-0 flex items-center justify-start px-6 md:px-12 lg:px-20">
                    <div class="max-w-xl text-white">
                        <h2 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">{{ $slide->judul }}</h2>
                        <p class="text-lg md:text-xl drop-shadow-md">{{ $slide->keterangan }}</p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="{{ route('gallery.article', $slide->gallery_id) }}" class="inline-flex items-center justify-center bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-full transition shadow-lg">Lebih Lanjut →</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="gallery-slide flex-shrink-0 w-full h-full relative bg-gray-800 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-image text-6xl mb-4 opacity-50"></i>
                    <p class="text-xl">Belum ada konten gallery</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Indikator Slide tanpa tombol tambah -->
    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 flex flex-col items-center space-y-3">
        <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="w-8 h-8 md:w-10 md:h-10 opacity-100 drop-shadow-lg">
        <div id="slideCounter" class="bg-black/50 backdrop-blur-sm text-white text-sm md:text-base font-semibold px-3 py-1 rounded-full">
            @if($slides->count() > 0)
                <span id="currentSlide">1</span> dari <span id="totalSlides">{{ $slides->count() }}</span>
            @else
                0 dari 0
            @endif
        </div>
        <div id="slideDots" class="flex flex-col space-y-2">
            @foreach($slides as $index => $slide)
                <div class="dot w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-white/50 transition-all duration-300 cursor-pointer hover:bg-white/80" data-index="{{ $index }}"></div>
            @endforeach
        </div>
    </div>
</section>

<!-- SECTION KEUNGGULAN -->
<section class="bg-auth-full relative py-20 px-6 overflow-hidden" data-aos="fade-up">
    <div class="auth-blur-circles"><div></div><div></div></div>
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-12">
            <span class="text-[#FF6B00] bg-orange-100 px-4 py-1 rounded-full text-sm"><i class="fas fa-star"></i> Mengapa Kami</span>
            <h2 class="text-3xl font-extrabold mt-4">Keunggulan Layanan <span class="text-[#FF6B00]">SIMBRO</span></h2>
        </div>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="card-white p-6 text-center"><div class="w-16 h-16 bg-[#FF6B00] rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-leaf text-white text-2xl"></i></div><h3 class="font-bold mt-4">Ayam Sehat & Alami</h3><p class="text-gray-500 text-sm">Pakan alami, tanpa hormon.</p></div>
            <div class="card-white p-6 text-center"><div class="w-16 h-16 bg-[#FF6B00] rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-truck-fast text-white text-2xl"></i></div><h3 class="font-bold mt-4">Pengiriman Cepat</h3><p class="text-gray-500 text-sm">Sampai dalam 2 jam.</p></div>
            <div class="card-white p-6 text-center"><div class="w-16 h-16 bg-[#FF6B00] rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-chart-line text-white text-2xl"></i></div><h3 class="font-bold mt-4">Sistem Terintegrasi</h3><p class="text-gray-500 text-sm">Pantau pesanan realtime.</p></div>
            <div class="card-white p-6 text-center"><div class="w-16 h-16 bg-[#FF6B00] rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-hand-holding-usd text-white text-2xl"></i></div><h3 class="font-bold mt-4">Harga Kompetitif</h3><p class="text-gray-500 text-sm">Langsung dari sumber.</p></div>
        </div>
    </div>
</section>

<!-- SECTION PRODUK -->
<section id="produk" class="bg-clear-white py-12 px-4 md:py-20 md:px-6" data-aos="fade-up">
    <div class="max-w-7xl mx-auto">
        <div class="inline-flex items-center gap-2 bg-orange-100 rounded-full px-4 py-1.5 mb-4">
            <i class="fas fa-egg text-[#FF6B00] text-sm"></i>
            <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-wider">Ayam Berkualitas Unggul</span>
         </div>
        <div class="flex justify-between items-center mb-6 md:mb-4">
            <h2 class="text-2xl md:text-3xl font-extrabold">Produk <span class="text-[#FF6B00]">Kami</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-16">
            <div class="md:col-span-2">
                <h3 class="text-sm md:text-base font-semibold mb-5">Geser ke kanan untuk lihat semua produk <i class="fas fa-arrow-right text-xs"></i></h3>
                <div class="overflow-x-auto py-4 -my-4 pb-2 -mx-2 px-2 scrollbar-none">
                    <div class="flex space-x-4 md:space-x-6" style="min-width: min-content;">
                        @forelse($produk as $item)
                            @php
                                $satuan = ($item->kategori == 'Bibit Ayam Broiler') ? 'ekor' : 'kg';
                                $minStok = ($item->kategori == 'Bibit Ayam Broiler') ? 60 : 2;
                                $status = $item->stok >= $minStok ? 'Tersedia' : 'Habis';
                                $statusClass = $status == 'Tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                            @endphp
                            <div class="flip-card w-56 md:w-64 flex-shrink-0 h-[290px] md:h-[310px] cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" data-id="{{ $item->produk_id }}">
                                <div class="flip-card-inner relative w-full h-full transition-transform duration-500 transform-style-preserve-3d">
                                    <div class="flip-card-front absolute w-full h-full backface-hidden bg-white rounded-2xl shadow-md overflow-hidden flex flex-col">
                                        <div class="h-44 md:h-48 overflow-hidden bg-gray-100">
                                            @if($item->foto) <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover"> @else <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div> @endif
                                        </div>
                                        <div class="p-2 md:p-3 flex-1 flex flex-col">
                                            <div class="flex justify-between items-start gap-2">
                                                <h3 class="text-xs md:text-sm font-bold text-gray-800">{{ $item->nama_produk }}</h3>
                                                <span class="inline-block px-1.5 py-0.5 text-[10px] md:text-xs font-semibold rounded-full {{ $statusClass }}">{{ $status }}</span>
                                            </div>
                                            <p class="text-sm md:text-lg font-bold text-[#FF6B00] mt-1">Rp{{ number_format($item->harga, 0, ',', '.') }} / {{ $satuan }}</p>
                                            <div class="mt-auto pt-2 text-center text-gray-400 text-[10px] md:text-xs flex items-center justify-center gap-1">
                                                <span>Klik untuk detail</span> <i class="fas fa-arrow-right text-xs"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flip-card-back absolute w-full h-full backface-hidden bg-white rounded-2xl shadow-md overflow-hidden rotate-y-180 flex flex-col">
                                        <div class="bg-gradient-to-r from-orange-50 to-white p-2 md:p-3 border-b">
                                            <h3 class="text-sm md:text-base font-bold text-gray-800">{{ $item->nama_produk }}</h3>
                                        </div>
                                        <div class="flex-1 p-2 md:p-3 space-y-1.5 md:space-y-2 text-[10px] md:text-xs overflow-y-auto">
                                            <div class="flex items-start gap-2"><i class="fas fa-align-left text-[#FF6B00] w-4 mt-0.5"></i><p><span class="font-semibold">Deskripsi:</span> {{ \Illuminate\Support\Str::limit($item->deskripsi, 70) }}</p></div>
                                            <div class="flex items-center gap-2"><i class="fas fa-tag text-[#FF6B00] w-4"></i><p><span class="font-semibold">Kategori:</span> {{ $item->kategori }}</p></div>
                                            <div class="flex items-center gap-2"><i class="fas fa-boxes text-[#FF6B00] w-4"></i><p><span class="font-semibold">Stok:</span> {{ $item->stok }} {{ $satuan }}</p></div>
                                            <div class="flex items-center gap-2"><i class="fas fa-money-bill-wave text-[#FF6B00] w-4"></i><p><span class="font-semibold">Harga:</span> Rp {{ number_format($item->harga, 0, ',', '.') }} / {{ $satuan }}</p></div>
                                        </div>
                                        <div class="mt-1 mb-1 md:mt-2 md:mb-2 text-center text-gray-400 text-[10px] md:text-xs flex items-center justify-center gap-1">
                                            <i class="fas fa-undo-alt text-xs"></i>
                                            <span>Klik untuk balik</span>
                                        </div>
                                        <div class="p-3 border-t bg-gray-50">
                                            @if($status == 'Tersedia')
                                                <button onclick="window.location.href='{{ route('customer.transaksi.beli', $item->produk_id) }}'" class="w-full bg-[#FF6B00] hover:bg-orange-700 text-white font-semibold py-1.5 rounded-lg transition text-sm inline-flex items-center justify-center gap-2">
                                                    <i class="fas fa-shopping-cart"></i> Beli
                                                </button>
                                            @else
                                                <button disabled class="w-full bg-gray-400 cursor-not-allowed text-white font-semibold py-1.5 rounded-lg text-sm inline-flex items-center justify-center gap-2">
                                                    <i class="fas fa-times-circle"></i> Stok Habis
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="w-full text-center py-10 text-gray-500">Belum ada produk.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="md:col-span-1">
                <div class="bg-gradient-to-br from-white to-orange-50 rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 sticky top-24 border border-orange-100">
                    <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-[#FF6B00] rounded-full flex items-center justify-center"><i class="fas fa-medal text-white text-sm md:text-lg"></i></div>
                        <h3 class="text-base md:text-xl font-bold text-gray-800">Jaminan Mutu Produk</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-xs md:text-sm">
                        CV. Mitra Gemuk Bersama dengan bangga menyajikan produk ayam broiler berkualitas premium.
                        Kami menerapkan standar higienis modern dari peternakan hingga ke meja Anda.
                        Setiap ayam dipastikan sehat, segar, dan diproses tanpa bahan pengawet atau hormon.
                        Dengan sertifikasi HALAL and sistem rantai dingin terintegrasi, kepercayaan pelanggan adalah prioritas utama kami.
                        Telah dipercaya oleh <span class="font-semibold text-[#FF6B00]">500+ mitra usaha</span> di seluruh Indonesia.
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2 text-[10px] md:text-xs text-gray-500">
                        <i class="fas fa-check-circle text-green-500"></i> <span>Teruji secara mikrobiologi</span>
                        <i class="fas fa-check-circle text-green-500 ml-2"></i> <span>Bebas residu & antibiotik</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION ULASAN -->
<section id="ulasan" class="bg-auth-full relative py-20 px-6 overflow-hidden" data-aos="fade-up">
    <div class="auth-blur-circles"><div></div><div></div></div>
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-12">
            <span class="text-[#FF6B00] bg-orange-100 px-4 py-1 rounded-full"><i class="fas fa-comment-dots"></i> Testimoni</span>
            <h2 class="text-3xl font-extrabold mt-2">Ulasan <span class="text-[#FF6B00]">Pelanggan</span></h2>
        </div>

        @if($ulasan && $ulasan->count() > 0)
            <div class="overflow-x-auto pb-6 scroll-smooth scrollbar-none">
                <div class="flex gap-6 w-max p-3">
                    @foreach($ulasan as $ulasanItem)
                        @php
                            $produk = $ulasanItem->transaksi->details->first()->produk ?? null;
                            $foto = $produk && $produk->foto ? Storage::url($produk->foto) : asset('images/default-product.jpg');
                            $namaProduk = $produk->nama_produk ?? 'Produk tidak tersedia';
                        @endphp

                        <!-- CARD ULASAN DIPERBESAR -->
                        <div class="bg-white border border-gray-100/80 rounded-2xl w-[380px] md:w-[420px] p-6 flex-shrink-0 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">

                            <!-- Header Card -->
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 flex items-center justify-center bg-orange-50 rounded-full">
                                        <i class="fas fa-comment-dots text-[22px] text-[#FF6B00]"></i>
                                    </div>
                                    <div class="truncate">
                                        <h4 class="font-bold text-base text-gray-800 tracking-tight truncate">{{ $ulasanItem->user->nama_lengkap }}</h4>
                                        <p class="text-xs text-gray-400 font-medium">{{ $ulasanItem->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-gray-300 text-xl font-serif opacity-40 leading-none">“</span>
                            </div>

                            <!-- Body Card: Foto produk di kiri, rating & ulasan di kanan -->
                            <div class="flex gap-5 items-start flex-1 mb-5">
                                <!-- Foto produk diperbesar -->
                                <div class="flex-shrink-0">
                                    <div class="relative group cursor-zoom-in">
                                        <img src="{{ $foto }}" alt="{{ $namaProduk }}" class="w-24 h-24 object-cover rounded-xl border border-gray-200 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 rounded-xl transition-opacity"></div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <!-- Rating bintang diperbesar -->
                                    <div class="mb-2 flex items-center gap-1">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fas fa-star {{ $i <= $ulasanItem->rating ? 'text-amber-400' : 'text-gray-200' }} text-base"></i>
                                        @endfor
                                    </div>
                                    <!-- Teks ulasan diperbesar -->
                                    <p class="text-gray-700 text-sm leading-relaxed line-clamp-3 font-medium italic cursor-help" title="{{ $ulasanItem->ulasan }}">
                                        "{{ $ulasanItem->ulasan }}"
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Card: Nama Produk -->
                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-sm">
                                <span class="text-gray-500 font-medium flex items-center gap-1.5">
                                    <i class="fas fa-shopping-bag text-xs text-gray-400"></i> Produk:
                                </span>
                                <span class="font-semibold text-[#FF6B00] bg-orange-50 px-2.5 py-1 rounded-md truncate max-w-[220px]" title="{{ $namaProduk }}">
                                    {{ $namaProduk }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-10 flex justify-center">
                <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-sm border border-gray-200">
                    <span class="text-sm font-semibold text-gray-600 tracking-wide">Geser untuk lihat ulasan lainnya</span>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 px-6 relative bg-gray-50/80 backdrop-blur-xl rounded-2xl border border-gray-200 shadow-md mt-6">
                <div class="w-28 h-28 mb-6 rounded-full bg-gray-200 flex items-center justify-center border-4 border-white shadow-inner">
                    <i class="fas fa-comment-medical text-5xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Belum Ada Ulasan</h3>
                <p class="text-gray-600 text-center max-w-md text-base leading-relaxed">
                    Jadilah pelanggan pertama yang membagikan pengalaman luar biasa Anda bersama produk <span class="font-semibold text-[#FF6B00]">SIMBRO</span>.
                </p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('click', function (e) {
        const card = e.target.closest('.flip-card');
        if (card) {
            // Jangan flip jika yang diklik adalah link atau button di dalam card
            if (e.target.closest('a') || e.target.closest('button')) {
                return;
            }
            card.classList.toggle('flipped');
        }
    });

    function initGallery() {
        const track = document.querySelector('.gallery-track');
        const slides = document.querySelectorAll('.gallery-slide');
        const currentSpan = document.getElementById('currentSlide');
        const totalSpan = document.getElementById('totalSlides');
        const dots = document.querySelectorAll('.dot');
        if (!track || slides.length === 0) return;

        let currentIndex = 0;
        const slideCount = slides.length;
        let autoSlideInterval;

        function updateIndicators() {
            if (currentSpan) currentSpan.innerText = currentIndex + 1;
            dots.forEach((dot, idx) => {
                if (idx === currentIndex) {
                    dot.classList.add('bg-white');
                    dot.classList.remove('bg-white/50');
                } else {
                    dot.classList.remove('bg-white');
                    dot.classList.add('bg-white/50');
                }
            });
        }

        function goToSlide(index) {
            if (index < 0) index = slideCount - 1;
            if (index >= slideCount) index = 0;
            currentIndex = index;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            updateIndicators();
        }

        function nextSlide() { goToSlide(currentIndex + 1); }
        function startAutoSlide() {
            if (autoSlideInterval) clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                goToSlide(idx);
                startAutoSlide();
            });
        });

        goToSlide(0);
        startAutoSlide();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initGallery);
    } else {
        initGallery();
    }
</script>
@endpush

@endsection
