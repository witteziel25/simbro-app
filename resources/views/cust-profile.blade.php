<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIMBRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<body class="font-sans bg-gray-50 min-h-screen flex flex-col">

    <nav class="p-6">
        <a href="{{ route('customer.home') }}" class="inline-flex items-center text-gray-600 hover:text-brand font-semibold transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Beranda
        </a>
    </nav>

    <main class="flex-grow flex items-center justify-center px-6 pb-12">
        <div class="max-w-2xl w-full bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100">
            
            <div class="bg-brand-black p-10 text-center relative">
                <div class="relative inline-block">
                    <div class="w-32 h-32 bg-gray-700 rounded-full border-4 border-brand flex items-center justify-center mx-auto overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <button class="absolute bottom-0 right-0 bg-brand p-2 rounded-full text-white shadow-lg hover:bg-orange-600 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>
                <h2 class="mt-4 text-white text-xl font-bold">Informasi Akun</h2>
                <p class="text-gray-400 text-sm">Kelola informasi data diri Anda di SIMBRO</p>
            </div>

            <div class="p-10 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-gray-400 mb-1">Nama Lengkap</p>
                        <p class="font-bold text-gray-800">Budi Santoso</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Username</p>
                        <p class="font-bold text-gray-800">budisan_99</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Email</p>
                        <p class="font-bold text-gray-800">budi@example.com</p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">No. HP</p>
                        <p class="font-bold text-gray-800">081234567890</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-400 mb-1">Alamat</p>
                        <p class="font-bold text-gray-800">Jl. Mastrip No. 164, Jember, Jawa Timur</p>
                    </div>
                </div>

                <button onclick="confirmLogout()" class="w-full mt-8 flex items-center justify-center gap-2 py-4 bg-red-50 text-red-600 font-bold rounded-2xl border border-red-100 hover:bg-red-600 hover:text-white transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar dari Akun
                </button>
            </div>
        </div>
    </main>

    <div id="logoutModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[100] backdrop-blur-sm px-6">
        <div class="bg-white p-8 rounded-[2rem] max-w-sm w-full shadow-2xl text-center">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">!</div>
            <h3 class="text-xl font-black text-gray-800 mb-2">Yakin Ingin Keluar?</h3>
            <p class="text-gray-500 text-sm mb-8 leading-relaxed">Anda harus melakukan login ulang untuk mengakses layanan SIMBRO kembali.</p>
            <div class="flex gap-4">
                <button onclick="closeModal()" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Tidak</button>
                <a href="{{ route('login') }}" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg shadow-red-200 transition-all">Ya, Keluar</a>
            </div>
        </div>
    </div>

    <script>
        function confirmLogout() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</body>
</html>