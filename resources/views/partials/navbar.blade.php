<header class="sticky top-0 bg-white/90 backdrop-blur-md shadow-sm z-50 py-4 px-6 md:px-12 flex flex-wrap justify-between items-center">
    <div class="flex items-center gap-2">
        <div class="w-10 h-10 bg-[#FF6B00] rounded-xl flex items-center justify-center"><i class="fas fa-drumstick-bite text-white"></i></div>
        <div><span class="font-extrabold text-2xl text-[#FF6B00]">SIMBRO</span><span class="block text-[9px] font-semibold text-gray-500 -mt-1">CV. Mitra Gemuk Bersama</span></div>
    </div>
    <div class="flex items-center gap-4">
        <nav class="flex gap-4 text-sm font-semibold">
            <a href="#gallery" class="nav-link text-gray-700 hover:text-[#FF6B00]">Gallery</a>
            <a href="#produk" class="nav-link text-gray-700 hover:text-[#FF6B00]">Produk</a>
            <a href="#" class="nav-link text-gray-700 hover:text-[#FF6B00]">Pembelian</a>
            <a href="#ulasan" class="nav-link text-gray-700 hover:text-[#FF6B00]">Ulasan</a>
            <a href="#tentang" class="nav-link text-gray-700 hover:text-[#FF6B00]">Tentang Kami</a>
        </nav>
        <a href="{{ route('customer.profile') }}" class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center hover:bg-[#FF6B00] transition">
            <i class="fas fa-user-circle text-xl text-[#FF6B00] hover:text-white"></i>
        </a>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('section[id], footer[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        function setActiveLink(activeId) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                const href = link.getAttribute('href').substring(1);
                if (href === activeId) link.classList.add('active');
            });
        }
        function onScroll() {
            let current = '';
            const scrollPos = window.scrollY + 120;
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });
            if (current) setActiveLink(current);
        }
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    setActiveLink(targetId);
                }
            });
        });
        window.addEventListener('scroll', onScroll);
        onScroll();
    });
</script>
