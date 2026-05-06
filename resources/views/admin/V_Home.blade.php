@extends('layouts.app')

@section('title', 'Beranda Admin - SIMBRO')

@section('content')

<!-- SECTION GALLERY  -->
<section id="gallery" class="relative w-full h-screen overflow-hidden">
    <div class="gallery-container relative w-full h-full">
        <div class="gallery-track flex h-full transition-transform duration-700 ease-out">
            @php
                $slides = [
                    ['image' => asset('images/gallery1.jpg'), 'title' => 'Peternakan Modern & Higienis', 'desc' => 'Teknologi canggih untuk menghasilkan ayam broiler terbaik'],
                    ['image' => asset('images/gallery2.jpg'), 'title' => 'Kontrol Kualitas Ketat', 'desc' => 'Setiap produk melalui serangkaian uji kualitas sebelum dikirim ke pelanggan.'],
                    ['image' => asset('images/gallery3.jpg'), 'title' => 'Pengiriman Tepat Waktu', 'desc' => 'Armada berpendingin memastikan kesegaran produk sampai ke tujuan.']
                ];
            @endphp
            @foreach($slides as $slide)
            <div class="gallery-slide flex-shrink-0 w-full h-full relative">
                <img src="{{ $slide['image'] }}" alt="Gallery" class="w-full h-full object-cover transition-transform duration-5000 ease-out">
                <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-black/80"></div>
                <div class="absolute inset-0 flex items-center justify-start px-6 md:px-12 lg:px-20">
                    <div class="max-w-xl text-white">
                        <h2 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">{{ $slide['title'] }}</h2>
                        <p class="text-lg md:text-xl drop-shadow-md">{{ $slide['desc'] }}</p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="#produk" class="inline-flex items-center justify-center bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-full transition shadow-lg">Lebih Lanjut →</a>
                            <div class="bg-white rounded-full shadow-xl p-3 inline-flex items-center gap-2 cursor-pointer hover:shadow-2xl transition">
                                <i class="fas fa-robot text-2xl text-[#FF6B00]"></i>
                                <span class="font-semibold text-gray-700 hidden md:inline">Bertanya dengan Chatbot</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 flex flex-col items-center space-y-3">
        <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="w-8 h-8 md:w-10 md:h-10 opacity-100 drop-shadow-lg">
        <div id="slideCounter" class="bg-black/50 backdrop-blur-sm text-white text-sm md:text-base font-semibold px-3 py-1 rounded-full">1 dari {{ count($slides) }}</div>
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
        <div class="flex justify-between items-center mb-6 md:mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold">Produk <span class="text-[#FF6B00]">Dijual</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-16">
            <!-- FRAME PRODUK -->
            <div class="md:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm md:text-base font-semibold">Geser untuk lihat semua produk <i class="fas fa-arrow-right text-xs"></i></h3>
                    <div class="flex gap-2">
                        <a href="{{ route('produk.deleted') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 md:py-2 md:px-4 rounded-lg shadow transition text-xs md:text-sm inline-flex items-center gap-1">
                            <i class="fas fa-trash-alt"></i> Produk Dihapus
                        </a>
                        <a href="{{ route('produk.tambah') }}" class="bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-1.5 px-3 md:py-2 md:px-4 rounded-lg shadow transition text-xs md:text-sm inline-flex items-center gap-1">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto pb-2 -mx-2 px-2">
                    <div class="flex space-x-4 md:space-x-6" style="min-width: min-content;">
                        @forelse($produk as $item)
                            @php
                                $status = $item->stok > 0 ? 'Tersedia' : 'Habis';
                                $statusClass = $item->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                                $satuan = ($item->kategori == 'Bibit Ayam Broiler') ? 'ekor' : 'kg';
                            @endphp
                            <div class="flip-card w-56 md:w-64 flex-shrink-0 h-[290px] md:h-[310px] cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" data-id="{{ $item->produk_id }}">
                                <div class="flip-card-inner relative w-full h-full transition-transform duration-500 transform-style-preserve-3d">
                                    <div class="flip-card-front absolute w-full h-full backface-hidden bg-white rounded-2xl shadow-md overflow-hidden flex flex-col">
                                        <div class="h-44 md:h-48 overflow-hidden bg-gray-100">
                                            @if($item->foto) <img src="{{ Storage::url($item->foto) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div> @endif
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
                                            @if(session('role') == 1)
                                                <div><span class="font-semibold">ID Produk:</span> {{ $item->produk_id }}</div>
                                            @endif
                                            <div class="flex items-start gap-2">
                                                <i class="fas fa-align-left text-[#FF6B00] w-4 mt-0.5"></i>
                                                <p><span class="font-semibold">Deskripsi:</span> {{ \Illuminate\Support\Str::limit($item->deskripsi, 70) }}</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-tag text-[#FF6B00] w-4"></i>
                                                <p><span class="font-semibold">Kategori:</span> {{ $item->kategori }}</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-boxes text-[#FF6B00] w-4"></i>
                                                <p><span class="font-semibold">Stok:</span> {{ $item->stok }} {{ $satuan }}</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-money-bill-wave text-[#FF6B00] w-4"></i>
                                                <p><span class="font-semibold">Harga:</span> Rp {{ number_format($item->harga, 0, ',', '.') }} / {{ $satuan }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-1 mb-1 md:mt-2 md:mb-2 text-center text-gray-400 text-[10px] md:text-xs flex items-center justify-center gap-1">
                                            <i class="fas fa-undo-alt text-xs"></i>
                                            <span>Klik untuk balik</span>
                                        </div>
                                        <div class="p-2 md:p-3 border-t bg-gray-50">
                                            <div class="flex gap-2">
                                                <a href="{{ route('produk.edit', $item->produk_id) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-1 rounded-lg transition text-[10px] md:text-xs font-semibold inline-flex items-center justify-center gap-1">
                                                    <i class="fas fa-edit text-[10px] md:text-xs"></i> Edit
                                                </a>
                                                <button onclick="confirmDelete({{ $item->produk_id }}, '{{ $item->nama_produk }}')" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 rounded-lg transition text-[10px] md:text-xs font-semibold inline-flex items-center justify-center gap-1">
                                                    <i class="fas fa-trash text-[10px] md:text-xs"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="w-full text-center py-10 text-gray-500">Belum ada produk. Silakan tambah produk.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- STATISTIK -->
            <div class="md:col-span-1">
                @php
                    $stokMenipis = $produk->filter(function($p) { return $p->stok < 50 && $p->stok > 0; })->count();
                    $stokHabis = $produk->filter(function($p) { return $p->stok == 0; })->count();
                    $totalInventaris = $produk->sum(function($p) { return $p->harga * $p->stok; });
                    $bibitCount = $produk->where('kategori', 'Bibit Ayam Broiler')->count();
                    $dewasaCount = $produk->where('kategori', 'Ayam Broiler Dewasa')->count();
                @endphp
                <div class="grid grid-cols-2 gap-3 md:block md:space-y-4">
                    <!-- Total Produk Aktif -->
                    <div class="bg-gradient-to-br from-white to-orange-50 rounded-xl md:rounded-2xl shadow-md p-3 md:p-4 border border-orange-100 flex items-center justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex items-center gap-2 md:gap-3">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-[#FF6B00] rounded-full flex items-center justify-center"><i class="fas fa-boxes text-white text-sm md:text-lg"></i></div>
                            <div><p class="text-xs md:text-sm font-semibold text-gray-800">Total Produk Aktif</p><p class="text-[10px] md:text-xs text-gray-500">produk terdaftar</p></div>
                        </div>
                        <p class="text-xl md:text-3xl font-extrabold text-[#FF6B00]">{{ $produk->count() }}</p>
                    </div>
                    <!-- Stok Menipis -->
                    <div class="bg-gradient-to-br from-white to-orange-50 rounded-xl md:rounded-2xl shadow-md p-3 md:p-4 border border-orange-100 flex items-center justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex items-center gap-2 md:gap-3"><div class="w-8 h-8 md:w-10 md:h-10 bg-[#FF6B00] rounded-full flex items-center justify-center"><i class="fas fa-exclamation-triangle text-white text-sm md:text-lg"></i></div><div><p class="text-xs md:text-sm font-semibold text-gray-800">Stok Menipis</p><p class="text-[10px] md:text-xs text-gray-500">stok &lt; 50</p></div></div>
                        <p class="text-xl md:text-3xl font-extrabold {{ $stokMenipis > 0 ? 'text-[#FF6B00]' : 'text-green-600' }}">{{ $stokMenipis }}</p>
                    </div>
                    <!-- Stok Habis -->
                    <div class="bg-gradient-to-br from-white to-orange-50 rounded-xl md:rounded-2xl shadow-md p-3 md:p-4 border border-orange-100 flex items-center justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex items-center gap-2 md:gap-3"><div class="w-8 h-8 md:w-10 md:h-10 bg-[#FF6B00] rounded-full flex items-center justify-center"><i class="fas fa-times-circle text-white text-sm md:text-lg"></i></div><div><p class="text-xs md:text-sm font-semibold text-gray-800">Stok Habis</p><p class="text-[10px] md:text-xs text-gray-500">stok = 0</p></div></div>
                        <p class="text-xl md:text-3xl font-extrabold text-orange-500">{{ $stokHabis }}</p>
                    </div>
                    <!-- Total Inventaris -->
                    <div class="bg-gradient-to-br from-white to-orange-50 rounded-xl md:rounded-2xl shadow-md p-3 md:p-4 border border-orange-100 flex items-center justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex items-center gap-2 md:gap-3"><div class="w-8 h-8 md:w-10 md:h-10 bg-[#FF6B00] rounded-full flex items-center justify-center"><i class="fas fa-money-bill-wave text-white text-sm md:text-lg"></i></div><div><p class="text-xs md:text-sm font-semibold text-gray-800">Total Inventaris</p><p class="text-[10px] md:text-xs text-gray-500">nilai seluruh stok</p></div></div>
                        <p class="text-base md:text-xl font-extrabold text-[#FF6B00]">Rp {{ number_format($totalInventaris, 0, ',', '.') }}</p>
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
        <div class="grid md:grid-cols-3 gap-8">
            <div class="card-white p-6"><div class="flex items-center gap-3"><img src="https://randomuser.me/api/portraits/men/42.jpg" class="w-12 h-12 rounded-full"><div><h4 class="font-bold">Budi Santoso</h4><div class="text-yellow-400 text-xs"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div></div></div><p class="italic text-gray-600 mt-3">"Ayam fresh, pengiriman tepat waktu. Puas!"</p></div>
            <div class="card-white p-6"><div class="flex items-center gap-3"><img src="https://randomuser.me/api/portraits/women/65.jpg" class="w-12 h-12 rounded-full"><div><h4 class="font-bold">Siti Aminah</h4><div class="text-yellow-400 text-xs"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div></div></div><p class="italic text-gray-600 mt-3">"Sistem SIMBRO memudahkan pesanan harian."</p></div>
            <div class="card-white p-6"><div class="flex items-center gap-3"><img src="https://randomuser.me/api/portraits/men/22.jpg" class="w-12 h-12 rounded-full"><div><h4 class="font-bold">Andi Wijaya</h4><div class="text-yellow-400 text-xs"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div></div></div><p class="italic text-gray-600 mt-3">"Harga kompetitif, stok selalu tersedia."</p></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function confirmDelete(id, nama) {
        if (typeof showConfirm === 'function') {
            showConfirm(`Apakah anda yakin ingin menghapus produk "${nama}"?`, function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('produk') }}/${id}`;
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            });
        } else {
            if (confirm(`Apakah anda yakin ingin menghapus produk "${nama}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('produk') }}/${id}`;
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        }
    }

    document.addEventListener('click', function (e) {
        const card = e.target.closest('.flip-card');
        if (card) {
            if (e.target.closest('a') || e.target.closest('button')) {
                return;
            }
            card.classList.toggle('flipped');
        }
    });

    @if(session('lightbox_message'))
        const msg = {!! json_encode(session('lightbox_message')) !!};
        const type = "{{ session('lightbox_type', 'success') }}";
        const sub = {!! json_encode(session('lightbox_sub', '')) !!};
        if (typeof showLightbox === "function") {
            showLightbox(msg, type, sub);
        }
    @endif

    function initGallery() {
        const track = document.querySelector('.gallery-track');
        const slides = document.querySelectorAll('.gallery-slide');
        const counter = document.getElementById('slideCounter');
        const dots = document.querySelectorAll('.dot');
        if (!track || slides.length === 0) return;

        let currentIndex = 0;
        const slideCount = slides.length;
        let autoSlideInterval;

        function updateActiveClass() {
            slides.forEach((slide, idx) => {
                if (idx === currentIndex) {
                    slide.classList.add('active');
                } else {
                    slide.classList.remove('active');
                }
            });
        }

        function updateIndicators() {
            if (counter) counter.innerText = (currentIndex + 1) + ' dari ' + slideCount;
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
            const translateX = -currentIndex * 100;
            track.style.transform = `translateX(${translateX}%)`;
            updateActiveClass();
            updateIndicators();
        }

        function nextSlide() {
            goToSlide(currentIndex + 1);
        }

        function startAutoSlide() {
            if (autoSlideInterval) clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 5000);
        }

        // Event klik pada dots
        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                goToSlide(idx);
                startAutoSlide();
            });
        });

        // Inisialisasi
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
