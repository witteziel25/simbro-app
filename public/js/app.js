/* Gallery Slider (versi lengkap dgn dots + counter + autoSlide) */
function initGallerySlider() {
    const track = document.querySelector('.gallery-track');
    const slides = document.querySelectorAll('.gallery-slide');
    const currentSpan = document.getElementById('currentSlide');
    const dots = document.querySelectorAll('.dot');
    if (!track || slides.length === 0) return;

    let currentIndex = 0;
    const slideCount = slides.length;
    let autoSlideInterval;

    function updateIndicators() {
        if (currentSpan) currentSpan.innerText = currentIndex + 1;
        slides.forEach((slide, idx) => {
            slide.classList.toggle('active', idx === currentIndex);
        });
        dots.forEach((dot, idx) => {
            dot.classList.toggle('bg-white', idx === currentIndex);
            dot.classList.toggle('bg-white/50', idx !== currentIndex);
        });
    }

    function goToSlide(index) {
        if (index < 0) index = slideCount - 1;
        if (index >= slideCount) index = 0;
        currentIndex = index;
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
        updateIndicators();
    }

    function startAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(() => goToSlide(currentIndex + 1), 5000);
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

/* AOS (Animate On Scroll) */
function initAOS() {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true, offset: 100 });
    }
}

/* Toggle Password Visibility */
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;
    const icon = field.nextElementSibling?.querySelector('i')
              || document.getElementById('icon_' + fieldId);
    if (field.type === 'password') {
        field.type = 'text';
        icon?.classList.remove('fa-eye-slash');
        icon?.classList.add('fa-eye');
    } else {
        field.type = 'password';
        icon?.classList.remove('fa-eye');
        icon?.classList.add('fa-eye-slash');
    }
}

/* Flip Card (klik card utk flip, skip jika klik link/button) */
function initFlipCard() {
    document.addEventListener('click', function(e) {
        const card = e.target.closest('.flip-card');
        if (card && !e.target.closest('a') && !e.target.closest('button')) {
            card.classList.toggle('flipped');
        }
    });
}

/* Konfirmasi Hapus Produk */
function confirmDelete(id, nama) {
    const doDelete = () => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/produk/${id}`;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_token';
            input.value = csrfToken;
            form.appendChild(input);
        }
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    };

    if (typeof showConfirm === 'function') {
        showConfirm(`Apakah anda yakin ingin menghapus produk "${nama}"?`, doDelete);
    } else if (confirm(`Apakah anda yakin ingin menghapus produk "${nama}"?`)) {
        doDelete();
    }
}

/* Toggle Detail Panel (accordion card) */
function toggleDetail(element) {
    const card = element.closest('.card-riwayat, .card-riwayat-customer');
    if (!card) return;
    const panel = card.querySelector('.detail-panel');
    const icon = element.querySelector('.dropdown-icon');
    if (panel) panel.classList.toggle('hidden');
    if (icon) icon.classList.toggle('rotate-180');
}

/* Lightbox helper: tampilkan pesan lalu jalankan callback setelah ditutup */
function showLightboxAndThen(message, callback) {
    if (typeof showLightbox === 'function') {
        showLightbox(message, 'error');
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

/* Inisialisasi */
document.addEventListener('DOMContentLoaded', () => {
    initGallerySlider();
    initAOS();
    initFlipCard();
});
