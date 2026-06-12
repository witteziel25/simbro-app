<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMBRO')</title>
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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')

    <style>
        /* Sembunyikan scrollbar untuk Chrome, Safari dan Opera */
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        /* Sembunyikan scrollbar untuk IE, Edge dan Firefox */
        .scrollbar-none {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>

<body class="font-sans antialiased relative overflow-x-hidden min-h-screen flex flex-col">
    <div class="fixed inset-0 -z-10 auth-bg">
        <svg class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,107,0,0.08)" stroke-width="1"/>
                </pattern>
                <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1.5" fill="rgba(255,107,0,0.15)" />
                </pattern>
                <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#FF6B00" stop-opacity="0.05" />
                    <stop offset="100%" stop-color="#FFB347" stop-opacity="0.08" />
                </linearGradient>
            </defs>
            <rect width="100%" height="100%" fill="url(#grad)" />
            <rect width="100%" height="100%" fill="url(#grid)" />
            <rect width="100%" height="100%" fill="url(#dots)" />
        </svg>
        <div class="absolute top-1/4 -left-20 w-80 h-80 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse animation-delay-2000"></div>
    </div>
    <main class="flex-1 flex flex-col">
        @hasSection('header_title')
        <div class="sticky top-0 z-40 bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10 shadow-md">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo-simbro-2.png') }}" alt="SIMBRO" class="h-10 md:h-12 w-auto drop-shadow-md">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold">@yield('header_title')</h1>
                        @hasSection('header_desc')
                        <p class="text-orange-100 text-xs md:text-sm leading-tight mt-1">@yield('header_desc')</p>
                        @endif
                    </div>
                </div>
                @hasSection('header_back_url')
                <div class="flex items-center gap-2 self-end sm:self-auto mt-2 sm:mt-0">
                    <i class="fas fa-arrow-left text-sm"></i>
                    <a href="@yield('header_back_url')" class="inline-flex items-center gap-2 text-white hover:text-orange-200 hover:underline transition text-xs md:text-sm font-bold">@yield('header_back_text', 'Kembali')</a>
                </div>
                @endif
            </div>
        </div>
        @endif
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>

    <div id="lightboxModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300 opacity-0 invisible p-3">
        <div id="lightboxContainer" class="relative max-w-2xl w-full mx-auto transition-all duration-300 scale-95" style="container-type: inline-size;">
            <img id="modalBgImage" src="" alt="Popup" class="w-full h-auto rounded-xl shadow-xl">

            <div class="absolute inset-0 flex items-center justify-end pr-[6cqi] md:pr-[8cqi] pt-[4cqi]">
                <div id="modalTextContainer" class="text-right w-[55%]">
                    <p id="modalMessage" class="text-gray-800 font-bold leading-tight" style="font-size: clamp(13px, 3.8cqi, 22px); margin-bottom: 1.5cqi;"></p>
                    <p id="modalSubMessage" class="text-gray-600 leading-snug" style="font-size: clamp(11px, 2.5cqi, 15px); margin-bottom: 2.5cqi;"></p>
                    <div id="modalBtnContainer" class="flex justify-end gap-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setModalStyle() {
            // Gaya sudah diatur secara proporsional via inline style di HTML
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

            const btnClass = "bg-[#FF6B00] hover:bg-orange-700 text-white font-semibold rounded-md transition shadow-md inline-flex items-center justify-center cursor-pointer";
            const btnClassError = "bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md transition shadow-md inline-flex items-center justify-center cursor-pointer";
            const btnStyle = "font-size: clamp(11px, 2.2cqi, 15px); padding: clamp(6px, 1.5cqi, 10px) clamp(10px, 3cqi, 20px); border-radius: 0.375rem; gap: 0.25rem;";

            if (type === 'success') {
                bgImage.src = "{{ asset('images/popup-lightbox-success.webp') }}";
                btnContainer.innerHTML = `<button id="modalOkBtn" class="${btnClass}" style="${btnStyle}">Dimengerti!</button>`;
            } else if (type === 'error') {
                bgImage.src = "{{ asset('images/popup-lightbox-warning.webp') }}";
                btnContainer.innerHTML = `<button id="modalOkBtn" class="${btnClassError}" style="${btnStyle}">Dimengerti!</button>`;
            } else {
                bgImage.src = "{{ asset('images/popup-lightbox-warning.webp') }}";
                btnContainer.innerHTML = `<button id="modalOkBtn" class="${btnClassError}" style="${btnStyle}">OK</button>`;
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
            bgImage.src = "{{ asset('images/popup-lightbox-warning.webp') }}";

            const btnStyleYes = "font-size: clamp(11px, 2.2cqi, 15px); padding: clamp(6px, 1.5cqi, 10px) clamp(10px, 3cqi, 20px); border-radius: 0.375rem; gap: 0.25rem;";
            const btnStyleNo = "font-size: clamp(11px, 2.2cqi, 15px); padding: clamp(6px, 1.5cqi, 10px) clamp(10px, 3cqi, 20px); border-radius: 0.375rem; gap: 0.25rem;";
            
            btnContainer.innerHTML = `
                <button id="confirmYes" class="bg-red-600 hover:bg-red-700 text-white font-semibold transition shadow-md inline-flex items-center justify-center cursor-pointer" style="${btnStyleYes}">Iya</button>
                <button id="confirmNo" class="bg-transparent border border-red-600 hover:bg-red-50 text-red-600 font-semibold transition shadow-md inline-flex items-center justify-center cursor-pointer" style="${btnStyleNo}">Tidak</button>
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

        @if(session('lightbox_message'))
            showLightbox(@json(session('lightbox_message')), @json(session('lightbox_type')));
        @endif
    </script>

    @stack('scripts')

    <style>.animation-delay-2000 { animation-delay: 2s; }</style>

</body>

</html>
