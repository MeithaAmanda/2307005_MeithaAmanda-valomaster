<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;700;800&display=swap" rel="stylesheet">
    <style> 
        body { 
            font-family: 'Oxanium', sans-serif; 
            background-color: #0f1923; 
            color: white;
            background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.03) 1px, transparent 0);
            background-size: 40px 40px;
        }
        .glass-card { 
            background: rgba(23, 33, 43, 0.8); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 70, 85, 0.2);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
    </style>
    <title>ValoMaster // Daftar Akun</title>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div class="absolute top-10 right-10 text-[80px] font-bold opacity-[0.02] select-none uppercase italic">Register</div>
    <div class="absolute bottom-10 left-10 text-[80px] font-bold opacity-[0.02] select-none uppercase italic text-[#ff4655]">Identity</div>

    <div class="w-full max-w-md p-10 glass-card relative z-10 rounded-sm">
        <div class="flex flex-col items-center mb-8">
            <h1 class="text-white font-black italic uppercase tracking-tighter text-4xl text-center">
                Valo<span class="text-[#ff4655]">Master</span>
            </h1>
            <p class="text-[9px] font-bold text-gray-500 uppercase tracking-[0.4em] mt-2 opacity-60">BUAT AKUN BARU</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 block mb-2">Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Siapa nama kamu?" 
                       class="w-full bg-black/40 border border-white/10 p-3 outline-none focus:border-[#ff4655] transition text-sm italic font-bold placeholder:text-gray-700">
            </div>

            <div>
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 block mb-2">Alamat Email</label>
                <input type="email" name="email" required placeholder="email@kamu.com" 
                       class="w-full bg-black/40 border border-white/10 p-3 outline-none focus:border-[#ff4655] transition text-sm italic font-bold placeholder:text-gray-700">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 block mb-2">Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Min. 6 Karakter" 
                           class="w-full bg-black/40 border border-white/10 p-3 text-xs outline-none focus:border-[#ff4655] transition italic font-bold">
                </div>
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 block mb-2">Ulangi Sandi</label>
                    <input type="password" name="password_confirmation" required placeholder="Ketik ulang..." 
                           class="w-full bg-black/40 border border-white/10 p-3 text-xs outline-none focus:border-[#ff4655] transition italic font-bold">
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-[#ff4655] py-4 text-[10px] font-black uppercase tracking-[0.3em] text-white hover:bg-white hover:text-black transition-all duration-500 transform active:scale-95 shadow-[0_5px_15px_rgba(255,70,85,0.2)] mt-4">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 text-center border-t border-white/5 pt-6">
            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-[#ff4655] font-bold hover:underline ml-1 italic">Masuk Di Sini</a>
            </p>
        </div>
    </div>
</body>
</html>