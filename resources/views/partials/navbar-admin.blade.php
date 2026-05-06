<header class="sticky top-0 bg-white/90 backdrop-blur-md shadow-sm z-50 py-6 px-6 md:px-12 flex flex-wrap justify-between items-center border-b-2 border-[#FF6B00]">
    <div class="flex items-center gap-2">
        <img src="{{ asset('images/logo-simbro-1.png') }}" alt="SIMBRO" class="w-10 h-10 object-contain">
        <div>
            <span class="font-extrabold text-2xl text-[#FF6B00]">SIMBRO Admin</span>
            <span class="block text-[9px] font-semibold text-gray-500 -mt-1">CV. Mitra Gemuk Bersama</span>
        </div>
    </div>
    <div class="flex items-center gap-6">
        <nav class="flex gap-6 text-l font-semibold">
            <a href="#gallery" class="nav-link text-gray-700 hover:text-[#FF6B00]">Gallery</a>
            <a href="#produk" class="nav-link text-gray-700 hover:text-[#FF6B00]">Produk</a>
            <a href="#manajemen" class="nav-link text-gray-700 hover:text-[#FF6B00]">Manajemen</a>
            <a href="#ulasan" class="nav-link text-gray-700 hover:text-[#FF6B00]">Ulasan</a>
        </nav>
        <div class="relative">
            <button id="profileDropdownBtn" class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center hover:bg-[#FF6B00] transition focus:outline-none">
                <i class="fas fa-user-gear text-xl text-[#FF6B00] hover:text-white"></i>
            </button>
            <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 hidden z-50">
                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#FF6B00] rounded-t-lg">
                    <i class="fas fa-user-circle mr-2"></i> Data Akun Admin
                </a>
                <a href="{{ route('admin.data.customer') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-[#FF6B00] rounded-b-lg">
                    <i class="fas fa-users mr-2"></i> Data Akun Customer
                </a>
            </div>
        </div>
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

        const dropdownBtn = document.getElementById('profileDropdownBtn');
        if (dropdownBtn) {
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdown = document.getElementById('profileDropdown');
                dropdown.classList.toggle('hidden');
            });
            window.addEventListener('click', function(e) {
                const dropdown = document.getElementById('profileDropdown');
                const btn = document.getElementById('profileDropdownBtn');
                if (!btn?.contains(e.target)) {
                    dropdown?.classList.add('hidden');
                }
            });
        }
    });
</script>
