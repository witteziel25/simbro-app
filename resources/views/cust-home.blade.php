<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - SIMBRO Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        /* Khusus beranda, kita beri warna dasar putih agar bersih */
        body { background-color: #ffffff; }
        .text-brand { color: #FF6B00; }
        .bg-brand { background-color: #FF6B00; }
    </style>
</head>
<body class="font-sans">

    <header class="w-full py-6 px-10 flex justify-between items-center bg-white shadow-sm sticky top-0 z-50">
        <div class="flex flex-col">
            <span class="font-black text-2xl tracking-tighter text-brand leading-none">SIMBRO</span>
            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">CV. Mitra Gemuk Bersama</span>
        </div>

        <nav class="flex items-center gap-8">
            <a href="#" class="font-bold text-gray-700 hover:text-brand transition-colors">Produk</a>
            <a href="{{ route('customer.profile') }}" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center cursor-pointer hover:bg-gray-300 transition-all border-2 border-brand">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </a>
        </nav>
    </header>

    <section class="w-full bg-brand py-24 px-10 text-white flex flex-col items-center text-center">
        <h2 class="text-4xl md:text-5xl font-black mb-4 italic uppercase">Kualitas Ayam Broiler Terbaik</h2>
        <p class="max-w-2xl text-orange-100 font-light leading-relaxed">
            Kami memastikan setiap pasokan ayam broiler diproses dengan standar fasilitas modern untuk menghasilkan daging yang sehat, segar, dan berkualitas tinggi bagi kebutuhan bisnis Anda.
        </p>
        <div class="mt-10 flex gap-4">
            <div class="w-32 h-32 bg-orange-600 rounded-2xl flex items-center justify-center font-bold text-xs">FOTO AYAM 1</div>
            <div class="w-32 h-32 bg-orange-600 rounded-2xl flex items-center justify-center font-bold text-xs">FOTO AYAM 2</div>
            <div class="w-32 h-32 bg-orange-600 rounded-2xl flex items-center justify-center font-bold text-xs">FOTO AYAM 3</div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto py-20 px-6">
        <div class="text-center mb-12">
            <h3 class="text-2xl font-bold text-gray-800">Apa Kata Mereka?</h3>
            <div class="w-12 h-1 bg-brand mx-auto mt-2"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-brand-black rounded-full overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=1A1A1A&color=fff" alt="User">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-800">Budi Santoso</h4>
                        <span class="text-xs text-gray-500">@budisan_restauran</span>
                    </div>
                </div>
                <p class="text-gray-600 text-sm italic leading-relaxed">
                    "Kualitas ayamnya luar biasa, dagingnya tebal dan selalu segar saat sampai di lokasi. Rekomendasi banget!"
                </p>
            </div>

            <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-brand-black rounded-full overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=1A1A1A&color=fff" alt="User">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-800">Siti Aminah</h4>
                        <span class="text-xs text-gray-500">@siti_katering</span>
                    </div>
                </div>
                <p class="text-gray-600 text-sm italic leading-relaxed">
                    "Pelayanan admin cepat dan sistem SIMBRO sangat memudahkan saya untuk memantau pesanan setiap harinya."
                </p>
            </div>

            <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-brand-black rounded-full overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Andi+Wijaya&background=1A1A1A&color=fff" alt="User">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-800">Andi Wijaya</h4>
                        <span class="text-xs text-gray-500">@andi_freshmart</span>
                    </div>
                </div>
                <p class="text-gray-600 text-sm italic leading-relaxed">
                    "Gak pernah kecewa sama CV. Mitra Gemuk Bersama. Pengiriman tepat waktu dan ayam selalu sehat."
                </p>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 py-12 px-6 text-center">
        <div class="max-w-2xl mx-auto">
            <h4 class="font-black text-xl text-brand mb-2 italic">CV. MITRA GEMUK BERSAMA</h4>
            <p class="text-gray-500 text-sm mb-1">Jl. Raya Jember No. 88, Jember, Jawa Timur</p>
            <p class="text-gray-500 text-sm mb-6">Hubungi Kami: +62 812 3456 7890</p>
            <div class="pt-6 border-t border-gray-100 text-[10px] uppercase tracking-[0.2em] text-gray-400">
                &copy; 2026 CV. Mitra Gemuk Bersama. All Rights Reserved.
            </div>
        </div>
    </footer>

</body>
</html>