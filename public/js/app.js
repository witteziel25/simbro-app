// Gallery slider
function initGallerySlider() {
    const slides = document.querySelectorAll('.gallery-slide');
    if (slides.length === 0) return;
    let current = 0;
    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
        });
    }
    showSlide(current);
    setInterval(() => {
        current = (current + 1) % slides.length;
        showSlide(current);
    }, 5000);
}

// AOS
function initAOS() {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true, offset: 100 });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initGallerySlider();
    initAOS();
});
