@extends('layouts.V_App')

@section('title', 'Beranda Admin - SIMBRO')

@section('content')
{{-- Section Gallery --}}
<section id="gallery" class="relative w-full h-screen overflow-hidden">
    <div class="gallery-container relative w-full h-full">
        <div class="gallery-track flex h-full transition-transform duration-700 ease-out">
            @forelse($slides as $slide)
            <div class="gallery-slide flex-shrink-0 w-full h-full relative">
                <img src="{{ \App\Helpers\ImageHelper::getUrl($slide->gambar) }}" alt="{{ $slide->judul }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-black/80"></div>
                <div class="absolute inset-0 flex items-center justify-start px-6 md:px-12 lg:px-20">
                    <div class="max-w-xl text-white">
                        <h2 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">{{ $slide->judul }}</h2>
                        <p class="text-lg md:text-xl drop-shadow-md">{{ $slide->keterangan }}</p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="{{ route('gallery.article', $slide->gallery_id) }}" class="inline-flex items-center justify-center bg-[#FF6B00] text-white hover:bg-orange-700 font-bold py-3 px-8 rounded-lg transition shadow-lg">Lebih Lanjut →</a>
                            <a href="{{ route('chatbot.index') }}" class="inline-flex items-center justify-center bg-white border-2 border-[#FF6B00] text-[#FF6B00] hover:bg-orange-50 font-bold py-3 px-6 rounded-md transition shadow-md"><i class="fas fa-robot mr-2"></i> Tanya AI</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="gallery-slide flex-shrink-0 w-full h-full relative bg-gray-800 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-image text-6xl mb-4 opacity-50"></i>
                    <p class="text-xl">Belum ada konten gallery</p>
                    <p class="text-sm opacity-75">Klik tombol di bawah untuk menambahkan</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
    <div class="absolute bottom-[15%] md:bottom-[25%] right-6 md:right-12 lg:right-20 z-20 flex flex-row items-center space-x-4 md:space-x-6">
        <div id="slideCounter" class="bg-black/50 backdrop-blur-sm text-white text-xs md:text-sm font-semibold px-3 py-1.5 rounded-full shadow-sm">
            @if($slides->count() > 0)
                <span id="currentSlide">1</span> dari <span id="totalSlides">{{ $slides->count() }}</span>
            @else
                0 dari 0
            @endif
        </div>
        <div id="slideDots" class="flex flex-row space-x-2">
            @foreach($slides as $index => $slide)
                <div class="dot w-2 h-2 rounded-full bg-white/50 transition-all duration-500 cursor-pointer hover:bg-white/80" data-index="{{ $index }}"></div>
            @endforeach
        </div>

        @if(session('role') == 1)
        <div class="group ml-2">
            <a href="{{ route('admin.gallery.V_Create') }}"
               class="flex items-center justify-center h-10 w-10 group-hover:w-40 bg-white/20 backdrop-blur-md border border-white/50 rounded-full shadow-lg text-white overflow-hidden transition-all duration-300 ease-in-out hover:bg-[#FF6B00] hover:border-[#FF6B00]">
                <i class="fas fa-plus text-sm leading-none flex-shrink-0 group-hover:hidden"></i>
                <div class="hidden group-hover:flex items-center gap-2 px-4">
                    <i class="fas fa-plus text-sm leading-none flex-shrink-0"></i>
                    <span class="text-sm font-bold whitespace-nowrap leading-none">Tambah Konten</span>
                </div>
            </a>
        </div>
        @endif
    </div>
</section>
{{-- Section Produk --}}
<section id="produk" class="bg-clear-white py-12 px-4 md:py-20 md:px-6" data-aos="fade-up">
    <div class="max-w-7xl mx-auto">
        <div class="inline-flex items-center gap-2 bg-orange-100 rounded-full px-4 py-1.5 mb-4">
            <i class="fas fa-egg text-[#FF6B00] text-sm"></i>
            <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-wider">Ayam Berkualitas Unggul</span>
        </div>

        <div class="flex justify-between items-center mb-6 md:mb-4">
            <h2 class="text-2xl md:text-3xl font-extrabold">Produk <span class="text-[#FF6B00]">Dijual</span></h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-10">
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm md:text-base font-semibold">Produk dibedakan berdasarkan umur</h3>
                </div>
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
                                            @if($item->foto) <img src="{{ \App\Helpers\ImageHelper::getUrl($item->foto) }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover"> @else <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div> @endif
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
                                            <div><span class="font-semibold">ID Produk:</span> {{ $item->produk_id }}</div>
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
                                                <a href="{{ route('produk.edit', $item->produk_id) }}" class="flex-1 bg-[#FF6B00] hover:bg-orange-700 text-white text-center py-1 rounded-md transition text-[10px] md:text-xs font-semibold inline-flex items-center justify-center gap-1">
                                                    <i class="fas fa-edit text-[10px] md:text-xs"></i> Edit
                                                </a>
                                                <button onclick="confirmDelete({{ $item->produk_id }}, '{{ $item->nama_produk }}')" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 rounded-md transition text-[10px] md:text-xs font-semibold inline-flex items-center justify-center gap-1">
                                                    <i class="fas fa-trash-alt text-[10px] md:text-xs"></i> Hapus
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
            <div class="lg:col-span-1">
                <div class="flex flex-col sm:flex-row lg:flex-row gap-2 mb-6">
                    <a href="{{ route('produk.V_Tambah') }}" class="flex-1 btn-orange font-bold py-2 px-4 rounded-md shadow transition text-sm inline-flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                    <a href="{{ route('produk.deleted') }}" class="flex-1 btn-red font-bold py-2 px-4 rounded-md shadow transition text-sm inline-flex items-center justify-center gap-2">
                        <i class="fas fa-trash-alt"></i> Produk Dihapus
                    </a>
                </div>

                @php
                    // Hitung stok menipis berdasarkan kategori
                    $stokMenipis = 0;
                    foreach($produk as $p) {
                        if ($p->kategori == 'Bibit Ayam Broiler') {
                            if ($p->stok < 120 && $p->stok > 0) $stokMenipis++;
                        } elseif ($p->kategori == 'Ayam Broiler Dewasa') {
                            if ($p->stok < 20 && $p->stok > 0) $stokMenipis++;
                        }
                    }
                    $totalInventaris = $produk->sum(function($p) { return $p->harga * $p->stok; });
                @endphp
                <div class="flex flex-col gap-4">
                    <div class="bg-gradient-to-br from-white to-orange-50 rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-5 border border-orange-100 flex flex-row items-center justify-between gap-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#FF6B00] rounded-full flex flex-shrink-0 items-center justify-center"><i class="fas fa-boxes text-white text-base md:text-xl"></i></div>
                            <div><p class="text-sm md:text-base font-semibold text-gray-800">Total Produk Aktif</p><p class="text-xs md:text-sm text-gray-500">produk terdaftar</p></div>
                        </div>
                        <p class="text-2xl lg:text-3xl font-extrabold text-[#FF6B00]">{{ $produk->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-white to-orange-50 rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-5 border border-orange-100 flex flex-row items-center justify-between gap-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#FF6B00] rounded-full flex flex-shrink-0 items-center justify-center"><i class="fas fa-exclamation-triangle text-white text-base md:text-xl"></i></div>
                            <div><p class="text-sm md:text-base font-semibold text-gray-800">Stok Menipis</p><p class="text-xs md:text-sm text-gray-500">bibit &lt; 120 ekor / dewasa &lt; 20 kg</p></div>
                        </div>
                        <p class="text-2xl lg:text-3xl font-extrabold {{ $stokMenipis > 0 ? 'text-[#FF6B00]' : 'text-green-600' }}">{{ $stokMenipis }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-white to-orange-50 rounded-xl lg:rounded-2xl shadow-md p-4 lg:p-5 border border-orange-100 flex flex-row items-center justify-between gap-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#FF6B00] rounded-full flex flex-shrink-0 items-center justify-center"><i class="fas fa-money-bill-wave text-white text-base md:text-xl"></i></div>
                            <div><p class="text-sm md:text-base font-semibold text-gray-800">Total Inventaris</p><p class="text-xs md:text-sm text-gray-500">nilai seluruh stok</p></div>
                        </div>
                        <p class="text-xl lg:text-2xl font-extrabold text-[#FF6B00]">Rp {{ number_format($totalInventaris, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Section Ulasan --}}
<section id="ulasan" class="bg-auth-full relative py-20 px-6 overflow-hidden" data-aos="fade-up">
    <div class="auth-blur-circles"><div></div><div></div></div>
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 bg-orange-100 rounded-full px-4 py-1.5 mb-4">
                <i class="fas fa-comment-dots text-[#FF6B00] text-sm"></i>
                <span class="text-xs font-bold text-[#FF6B00] uppercase tracking-wider">Testimoni</span>
            </div>
            <div class="mb-6 md:mb-4">
                <h2 class="text-2xl md:text-3xl font-extrabold">Ulasan <span class="text-[#FF6B00]">Pelanggan</span></h2>
            </div>
            @if($ulasan && $ulasan->count() > 0)
                <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm px-6 py-2 rounded-full shadow-sm border border-gray-200">
                    <span class="text-sm font-semibold text-gray-600 tracking-wide">Geser untuk lihat ulasan lainnya</span>
                </div>
            @endif
        </div>

        @if($ulasan && $ulasan->count() > 0)
            <div class="overflow-x-auto py-4 -my-4 pb-2 -mx-2 px-2 scroll-smooth scrollbar-none">
                <div class="flex gap-6 w-max p-3">
                    @foreach($ulasan as $ulasanItem)
                        @php
                            $produk = $ulasanItem->transaksi->details->first()->produk ?? null;
                            $foto = $produk && $produk->foto ? \App\Helpers\ImageHelper::getUrl($produk->foto) : asset('images/default-product.jpg');
                            $namaProduk = $produk->nama_produk ?? 'Produk tidak tersedia';
                        @endphp
                        <div class="bg-white border border-gray-100/80 rounded-2xl w-[380px] md:w-[420px] p-6 flex-shrink-0 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 flex items-center justify-center bg-orange-50 rounded-full">
                                        <i class="fas fa-comment-dots text-[22px] text-[#FF6B00]"></i>
                                    </div>
                                    <div class="truncate">
                                        <h4 class="font-bold text-base text-gray-800 truncate">{{ $ulasanItem->user->nama_lengkap }}</h4>
                                        <p class="text-xs text-gray-400">{{ $ulasanItem->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-gray-300 text-xl font-serif opacity-40">“</span>
                            </div>
                            <div class="flex gap-5 items-start flex-1 mb-5">
                                <div class="flex-shrink-0">
                                    <img src="{{ $foto }}" alt="{{ $namaProduk }}" class="w-24 h-24 object-cover rounded-xl border border-gray-200 shadow-sm group-hover:scale-105 transition-transform">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="mb-2 flex items-center gap-1">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fas fa-star {{ $i <= $ulasanItem->rating ? 'text-amber-400' : 'text-gray-200' }} text-base"></i>
                                        @endfor
                                    </div>
                                    <p class="text-gray-700 text-sm leading-relaxed line-clamp-3 italic" title="{{ $ulasanItem->ulasan }}">
                                        "{{ $ulasanItem->ulasan }}"
                                    </p>
                                </div>
                            </div>
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

@endsection

