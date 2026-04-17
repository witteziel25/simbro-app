<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SIMBRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<body class="font-sans min-h-screen flex flex-col"> 

    <main class="flex-grow flex items-center justify-center px-6 py-12">
        <div class="max-w-5xl w-full grid md:grid-cols-2 bg-white rounded-[2rem] overflow-hidden shadow-2xl border border-gray-100">
            
            <div class="bg-brand-black p-12 text-white flex flex-col justify-center relative">
                <h1 class="text-3xl md:text-4xl font-bold mb-5 leading-tight">
                    Bergabung dengan <span class="text-brand">SIMBRO</span>
                </h1>
                <p class="text-gray-300 leading-relaxed font-light text-sm">
                    Daun pendaftaran Anda akan diproses untuk mendapatkan akses penuh ke manajemen operasional CV. Mitra Gemuk Bersama.
                </p>
            </div>

            <div class="p-10 pt-16 flex flex-col justify-center relative">
                <div class="absolute top-8 right-10 text-xs text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-brand font-bold hover:underline">Sign In</a>
                </div>

                <h2 class="text-2xl font-black mb-6 text-gray-800">Pendaftaran</h2>
                
                <form action="#" method="POST" class="space-y-4">
                    @csrf 
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="input-field w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Nama sesuai KTP" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                            <input type="email" name="email" class="input-field w-full px-4 py-2.5 rounded-xl text-sm" placeholder="alamat@email.com" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">No. HP</label>
                            <input type="text" name="phone" class="input-field w-full px-4 py-2.5 rounded-xl text-sm" placeholder="0812xxxx" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat</label>
                        <textarea name="address" rows="2" class="input-field w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Alamat lengkap tempat tinggal" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Username</label>
                            <input type="text" name="username" class="input-field w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Untuk login" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Password</label>
                            <input type="password" name="password" class="input-field w-full px-4 py-2.5 rounded-xl text-sm" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full text-white font-bold py-3.5 rounded-xl shadow-lg shadow-orange-100 mt-4 text-sm">
                        Daftar Sistem
                    </button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>