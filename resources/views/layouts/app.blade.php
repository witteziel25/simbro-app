<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMBRO - Mitra Ayam Broiler')</title>
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Simbro" />
    <link rel="manifest" href="/site.webmanifest" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')

    <style>
        /* Sembunyikan scrollbar untuk Chrome, Safari, dan Opera */
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        /* Sembunyikan scrollbar untuk IE, Edge, dan Firefox */
        .scrollbar-none {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>

<body class="font-sans antialiased">
    @if(session('role') == 1)
        @include('partials.navbar-admin')
    @else
        @include('partials.navbar')
    @endif
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <div id="lightboxModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300 opacity-0 invisible p-3">
        <div id="lightboxContainer" class="relative max-w-2xl w-full mx-auto transition-all duration-300 scale-95">
            <img id="modalBgImage" src="" alt="Popup" class="w-full h-auto rounded-xl shadow-xl">

            <div class="absolute inset-0 flex items-center justify-end pr-6 md:pr-10 pt-10">
                <div id="modalTextContainer" class="text-right max-w-[22rem] w-full">
                    <p id="modalMessage" class="text-gray-800 font-bold leading-tight"></p>
                    <p id="modalSubMessage" class="text-gray-600 leading-snug"></p>
                    <div id="modalBtnContainer" class="flex justify-end gap-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setModalStyle() {
            const msgEl = document.getElementById('modalMessage');
            const subMsgEl = document.getElementById('modalSubMessage');
            msgEl.className = 'text-gray-800 text-lg md:text-xl font-bold mb-2 leading-tight';
            subMsgEl.className = 'text-gray-600 text-base md:text-lg mb-3 leading-snug';
        }

        function showLightbox(message, type = 'success', subMessage = '') {
            const modal = document.getElementById('lightboxModal');
            const modalContent = modal.querySelector('.relative');
            const bgImage = document.getElementById('modalBgImage');
            const msgEl = document.getElementById('modalMessage');
            const subMsgEl = document.getElementById('modalSubMessage');
            const btnContainer = document.getElementById('modalBtnContainer');

            setModalStyle();

            msgEl.innerText = message;
            subMsgEl.innerText = subMessage || '';

            const btnClass = "bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded-lg transition shadow-md text-sm md:text-base inline-flex items-center justify-center gap-1 cursor-pointer";
            const btnClassError = "bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded-lg transition shadow-md text-sm md:text-base inline-flex items-center justify-center gap-1 cursor-pointer";

            if (type === 'success') {
                bgImage.src = "{{ asset('images/popup-lightbox-success.png') }}";
                btnContainer.innerHTML = `<button id="modalOkBtn" class="${btnClass}">Dimengerti!</button>`;
            } else if (type === 'error') {
                bgImage.src = "{{ asset('images/popup-lightbox-warning.png') }}";
                btnContainer.innerHTML = `<button id="modalOkBtn" class="${btnClassError}">Dimengerti!</button>`;
            } else {
                bgImage.src = "{{ asset('images/popup-lightbox-warning.png') }}";
                btnContainer.innerHTML = `<button id="modalOkBtn" class="${btnClassError}">OK</button>`;
            }

            document.getElementById('modalOkBtn').onclick = () => hideLightbox();

            modal.classList.remove('opacity-0', 'invisible');
            modal.classList.add('opacity-100', 'visible');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }

        function hideLightbox() {
            const modal = document.getElementById('lightboxModal');
            const modalContent = modal.querySelector('.relative');
            modal.classList.remove('opacity-100', 'visible');
            modal.classList.add('opacity-0', 'invisible');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
        }

        function showConfirm(message, onConfirm) {
            const modal = document.getElementById('lightboxModal');
            const modalContent = modal.querySelector('.relative');
            const bgImage = document.getElementById('modalBgImage');
            const msgEl = document.getElementById('modalMessage');
            const subMsgEl = document.getElementById('modalSubMessage');
            const btnContainer = document.getElementById('modalBtnContainer');

            setModalStyle();

            msgEl.innerText = message;
            subMsgEl.innerText = '';
            bgImage.src = "{{ asset('images/popup-lightbox-warning.png') }}";

            btnContainer.innerHTML = `
                <button id="confirmYes" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded-lg transition shadow-md text-sm md:text-base inline-flex items-center justify-center gap-1 mr-2 cursor-pointer">Iya</button>
                <button id="confirmNo" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-5 rounded-lg transition shadow-md text-sm md:text-base inline-flex items-center justify-center gap-1 cursor-pointer">Tidak</button>
            `;

            document.getElementById('confirmYes').onclick = () => {
                if (onConfirm) onConfirm();
                hideLightbox();
            };
            document.getElementById('confirmNo').onclick = () => {
                hideLightbox();
            };

            modal.classList.remove('opacity-0', 'invisible');
            modal.classList.add('opacity-100', 'visible');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }
    </script>

    @stack('scripts')

</body>

</html>
