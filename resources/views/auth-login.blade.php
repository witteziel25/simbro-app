<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMBRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<body class="font-sans min-h-screen flex flex-col"> 

    <main class="flex-grow flex items-center justify-center px-6">
        <div class="max-w-4xl w-full grid md:grid-cols-2 bg-white rounded-[2rem] overflow-hidden shadow-2xl border border-gray-100">
            
            <div class="bg-brand-black p-12 text-white flex flex-col justify-center relative">
                <h1 class="text-3xl md:text-4xl font-bold mb-5 leading-tight">
                    Selamat Datang di <span class="text-brand">SIMBRO</span>
                </h1>
                <p class="text-gray-300 leading-relaxed font-light text-sm">
                    Silakan masuk ke akun Anda untuk mengelola data operasional dan layanan pelanggan CV. Mitra Gemuk Bersama.
                </p>
            </div>

            <div class="p-12 pt-20 flex flex-col justify-center relative">
                <div class="absolute top-8 right-10 text-xs text-gray-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-brand font-bold hover:underline">Daftar Sekarang</a>
                </div>

                <h2 class="text-2xl font-black mb-10 text-gray-800">Login</h2>
                
                <form action="#" method="POST" class="space-y-6">
                    @csrf 
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Username</label>
                        <input type="text" name="username" class="input-field w-full px-5 py-3.5 rounded-xl" placeholder="Masukkan username" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Password</label>
                        <input type="password" name="password" class="input-field w-full px-5 py-3.5 rounded-xl" placeholder="••••••••" required>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center text-gray-600 cursor-pointer">
                            <input type="checkbox" class="mr-2.5 rounded border-gray-300 text-brand focus:ring-brand"> Ingat saya
                        </label>
                        <a href="#" class="text-brand hover:underline font-semibold">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn-primary w-full text-white font-bold py-4 rounded-xl shadow-lg shadow-orange-100 mt-8">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>