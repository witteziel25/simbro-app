// GALLERY SLIDER
function initGallerySlider() {
    const track = document.querySelector('.gallery-track');
    const slides = document.querySelectorAll('.gallery-slide');
    if (!track || slides.length === 0) return;

    let currentIndex = 0;
    const slideCount = slides.length;

    function updateActiveClass() {
        slides.forEach((slide, idx) => {
            if (idx === currentIndex) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
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
    }

    updateActiveClass();
    setInterval(() => {
        goToSlide(currentIndex + 1);
    }, 5000);
}

// AOS
function initAOS() {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true, offset: 100 });
    }
}

// TOGGLE PASSWORD
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    if (field) {
        const icon = field.nextElementSibling?.querySelector('i');
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
}

// KONFIRMASI HAPUS PRODUK
function confirmDelete(id, nama) {
    if (confirm(`Apakah anda yakin ingin menghapus produk "${nama}"?`)) {
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
    }
}

// INISIALISASI
document.addEventListener('DOMContentLoaded', () => {
    initGallerySlider();
    initAOS();
    initFlipCard();
});
