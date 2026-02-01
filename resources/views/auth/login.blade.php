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
    <title>ValoMaster // Masuk ke Akun</title>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div class="absolute top-10 left-10 text-[80px] font-bold opacity-[0.02] select-none uppercase italic">Access</div>
    <div class="absolute bottom-10 right-10 text-[80px] font-bold opacity-[0.02] select-none uppercase italic text-[#ff4655]">Login</div>

    <div class="w-full max-w-md p-10 glass-card relative z-10 rounded-sm">
        <div class="flex flex-col items-center mb-10">
            <h1 class="text-white font-black italic uppercase tracking-tighter text-4xl">
                Valo<span class="text-[#ff4655]">Master</span>
            </h1>
        </div>
        
        <form action="{{ url('/login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="text-[10px] font-bold uppercase tracking-widest text-gray-400 block mb-2">Alamat Email</label>
                <input type="email" name="email" required placeholder="Masukkan email kamu..."
                       class="w-full bg-black/40 border border-white/10 p-4 outline-none focus:border-[#ff4655] transition text-sm text-white placeholder:text-gray-700">
            </div>
            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-2">Kata Sandi</label>
                <input type="password" name="password" required placeholder="Masukkan kata sandi..."
                       class="w-full bg-black/40 border border-white/10 p-4 outline-none focus:border-[#ff4655] transition text-sm text-white placeholder:text-gray-700">
            </div>

            @if($errors->any())
                <p class="text-[10px] text-[#ff4655] font-bold uppercase italic tracking-widest text-center">
                    {{ $errors->first() }}
                </p>
            @endif

            <button type="submit" 
                    class="w-full bg-[#ff4655] py-4 font-black uppercase tracking-widest text-xs text-white hover:bg-white hover:text-black transition-all duration-300 transform active:scale-95 shadow-[0_5px_15px_rgba(255,70,85,0.2)]">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-10 pt-6 border-t border-white/5 text-center">
            <p class="text-[10px] text-gray-500 uppercase tracking-widest">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#ff4655] font-bold hover:underline ml-1">Daftar Di Sini</a>
            </p>
        </div>
    </div>

</body>
</html>