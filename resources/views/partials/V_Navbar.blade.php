<header class="sticky top-0 bg-white/90 backdrop-blur-md shadow-sm z-50 py-4 md:py-6 px-4 md:px-12 flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0 border-b-2 border-[#FF6B00]">
    <div class="flex items-center gap-2">
        <img src="{{ asset('images/logo-simbro-1.png') }}" alt="SIMBRO" class="w-10 h-10 object-contain">
        <div>
            <span class="font-extrabold text-xl md:text-2xl text-[#FF6B00]">SIMBRO</span>
            <span class="block text-[8px] md:text-[9px] font-semibold text-gray-500 -mt-1">CV. Mitra Gemuk Bersama</span>
        </div>
    </div>
    <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 w-full md:w-auto">
        <nav class="flex flex-wrap justify-center gap-4 md:gap-6 text-sm md:text-base font-semibold w-full md:w-auto">
            <a href="#gallery" class="nav-link text-gray-700 hover:text-[#FF6B00]">Gallery</a>
            <a href="#produk" class="nav-link text-gray-700 hover:text-[#FF6B00]">Produk</a>
            <a href="{{ route('customer.riwayat.transaksi') }}" class="nav-link text-gray-700 hover:text-[#FF6B00]">Pembelian</a>
            <a href="#ulasan" class="nav-link text-gray-700 hover:text-[#FF6B00]">Ulasan</a>
        </nav>
        <a href="{{ route('customer.profile') }}" class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center hover:bg-[#FF6B00] transition flex-shrink-0">
            <i class="fas fa-user-circle text-xl text-[#FF6B00] hover:text-white"></i>
        </a>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const navbar = document.querySelector('header');
                    const navbarHeight = navbar ? navbar.offsetHeight : 0;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 10; // -10 untuk sedikit ruang
                    window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                }
            });
        });
    });
</script>
