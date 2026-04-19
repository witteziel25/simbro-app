@extends('layouts.app')

@section('title', 'Beranda - SIMBRO')

@section('content')
<!-- Gallery Section -->
<section id="gallery" class="relative w-full h-[600px] overflow-hidden">
    @php
        $slides = [
            ['image' => 'https://images.unsplash.com/photo-1615937657715-bc7b4b7962c1?w=1600', 'title' => 'Penyedia Solusi Total Unggas di Indonesia', 'desc' => 'Sejak tahun 1975, kualitas produk kami diimbangi dengan luas dan dalamnya layanan bernilai tambah kami'],
            ['image' => 'https://images.unsplash.com/photo-1625938144755-5a5b4c6d63e0?w=1600', 'title' => 'Peternakan Modern & Higienis', 'desc' => 'Teknologi canggih untuk menghasilkan ayam broiler terbaik'],
            ['image' => 'https://images.unsplash.com/photo-1587593819583-62f1c6b4f7d2?w=1600', 'title' => 'Kualitas Premium', 'desc' => 'Daging segar, bersih, dan siap olah untuk bisnis Anda']
        ];
    @endphp
    @foreach($slides as $index => $slide)
    <div class="gallery-slide absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $slide['image'] }}'); display: {{ $index === 0 ? 'block' : 'none' }};">
        <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-4">
            <h2 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">{{ $slide['title'] }}</h2>
            <p class="text-lg md:text-xl max-w-2xl drop-shadow-md">{{ $slide['desc'] }}</p>
            <a href="#produk" class="mt-8 inline-block bg-[#FF6B00] hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-full transition shadow-lg">Lebih Lanjut →</a>
        </div>
    </div>
    @endforeach
    <div class="chatbot-float bg-white rounded-full shadow-xl p-3 flex items-center gap-2 cursor-pointer hover:shadow-2xl transition">
        <i class="fas fa-robot text-2xl text-[#FF6B00]"></i>
        <span class="font-semibold text-gray-700 hidden md:inline">Bertanya dengan Chatbot</span>
    </div>
</section>

<!-- Keunggulan -->
<section class="bg-auth-full relative py-20 px-6 overflow-hidden" data-aos="fade-up">
    <div class="auth-blur-circles"><div></div><div></div></div>
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-12">
            <span class="text-[#FF6B00] bg-orange-100 px-4 py-1 rounded-full text-sm"><i class="fas fa-star"></i> Mengapa Kami</span>
            <h2 class="text-3xl font-extrabold mt-4">Keunggulan Layanan <span class="text-[#FF6B00]">SIMBRO</span></h2>
        </div>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="card-white p-6 text-center"><div class="w-16 h-16 bg-[#FF6B00] rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-leaf text-white text-2xl"></i></div><h3 class="font-bold mt-4">Ayam Sehat & Alami</h3><p class="text-gray-500 text-sm">Pakan alami, tanpa hormon.</p></div>
            <div class="card-white p-6 text-center"><div class="w-16 h-16 bg-[#FF6B00] rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-truck-fast text-white text-2xl"></i></div><h3 class="font-bold mt-4">Rantai Dingin Modern</h3><p class="text-gray-500 text-sm">Armada berpendingin.</p></div>
            <div class="card-white p-6 text-center"><div class="w-16 h-16 bg-[#FF6B00] rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-chart-line text-white text-2xl"></i></div><h3 class="font-bold mt-4">Sistem Terintegrasi</h3><p class="text-gray-500 text-sm">Pantau pesanan realtime.</p></div>
            <div class="card-white p-6 text-center"><div class="w-16 h-16 bg-[#FF6B00] rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-hand-holding-usd text-white text-2xl"></i></div><h3 class="font-bold mt-4">Harga Kompetitif</h3><p class="text-gray-500 text-sm">Langsung dari sumber.</p></div>
        </div>
    </div>
</section>

<!-- Produk Kami -->
<section id="produk" class="bg-clear-white py-20 px-6" data-aos="fade-up">
    <div class="max-w-6xl mx-auto text-center mb-10"><h2 class="text-3xl font-extrabold">Produk <span class="text-[#FF6B00]">Kami</span></h2></div>
    <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg"><img src="https://images.unsplash.com/photo-1604503468506-a8da13d82791?w=600" class="h-64 w-full object-cover"><div class="p-6"><h3 class="text-xl font-bold">Ayam Broiler Dewasa</h3><p class="text-gray-500">Berat ±1.2-1.5 kg, segar, siap olah.</p><div class="mt-4 text-[#FF6B00] font-bold">Rp 52.000/ekor</div></div></div>
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg"><img src="https://images.unsplash.com/photo-1587593819583-62f1c6b4f7d2?w=600" class="h-64 w-full object-cover"><div class="p-6"><h3 class="text-xl font-bold">Bibit Ayam Broiler (DOC)</h3><p class="text-gray-500">Day Old Chicken, vaksin lengkap, siap ternak.</p><div class="mt-4 text-[#FF6B00] font-bold">Rp 7.500/ekor</div></div></div>
    </div>
</section>

<!-- Ulasan -->
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
@endsection
