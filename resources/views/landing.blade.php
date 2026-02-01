<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Oxanium', sans-serif; background-color: #0f1923; color: white; scroll-behavior: smooth; }
        .hero-gradient { background: linear-gradient(135deg, rgba(255,70,85,0.1) 0%, rgba(15,25,35,1) 100%); }
        .glass { background: rgba(23, 33, 43, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .tier-card:hover img { filter: drop-shadow(0 0 15px rgba(255, 70, 85, 0.6)); }
        [x-cloak] { display: none !important; }
    </style>
    <title>VALOMASTER // Landing Page</title>
</head>
<body class="selection:bg-[#ff4655] selection:text-white">

    <nav class="fixed top-0 w-full z-50 p-6 flex justify-between items-center px-12 glass border-b border-white/5">
        <h1 class="text-white font-black italic uppercase tracking-tighter text-2xl">Valo<span class="text-[#ff4655]">Master</span></h1>
        <div class="flex items-center gap-8">
            <a href="#fitur" class="text-[10px] font-bold uppercase tracking-[0.3em] hover:text-[#ff4655] transition-all">Fitur</a>
            <a href="#peringkat" class="text-[10px] font-bold uppercase tracking-[0.3em] hover:text-[#ff4655] transition-all">Peringkat</a>
            <a href="{{ route('login') }}" class="bg-[#ff4655] px-8 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all">LOG IN SEKARANG</a>
        </div>
    </nav>

    <header class="relative h-screen flex flex-col items-center justify-center overflow-hidden hero-gradient">
        <div class="text-center z-10 px-6">
            <p class="text-[12px] font-black tracking-[0.8em] text-[#ff4655] uppercase mb-6 animate-pulse">// VALORANT TACTICAL DASHBOARD //</p>
            <h1 class="text-6xl md:text-9xl font-black italic uppercase tracking-tighter leading-none mb-8">
                MASTER YOUR <br> <span class="text-[#ff4655]">VALORANT</span>
            </h1>
            <p class="max-w-2xl mx-auto text-gray-400 text-sm md:text-lg italic leading-relaxed mb-12">
                Simpan agent favorit mu, susun strategi di setiap map, dan kelola koleksi senjata favoritmu dalam satu platform terpusat.
            </p>
            <div class="flex flex-col md:flex-row gap-6 justify-center">
                <a href="{{ route('register') }}" class="bg-[#ff4655] px-12 py-4 text-xs font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all shadow-2xl">Buat Akun Sekarang</a>
                <a href="#fitur" class="border border-white/10 px-12 py-4 text-xs font-black uppercase tracking-widest hover:bg-white/5 transition-all">Lihat Fitur Utama</a>
            </div>
        </div>
    </header>

    <section id="fitur" class="py-32 px-12 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="glass p-10 border-l-4 border-[#ff4655]">
                <h3 class="text-2xl font-black uppercase italic mb-4">Tim Agent</h3>
                <p class="text-gray-500 text-sm leading-relaxed italic">Kelola daftar agent pilihanmu dengan detail kemampuan yang lengkap langsung dari API resmi.</p>
            </div>
            <div class="glass p-10 border-l-4 border-[#ff4655]">
                <h3 class="text-2xl font-black uppercase italic mb-4">Taktik Maps</h3>
                <p class="text-gray-500 text-sm leading-relaxed italic">Catat setiap strategi unik di setiap Maps untuk meningkatkan performa permainanmu.</p>
            </div>
            <div class="glass p-10 border-l-4 border-[#ff4655]">
                <h3 class="text-2xl font-black uppercase italic mb-4">Koleksi Senjata</h3>
                <p class="text-gray-500 text-sm leading-relaxed italic">Eksplorasi skin senjata dan simpan desain favoritmu ke dalam koleksi pribadimu.</p>
            </div>
        </div>
    </section>

    <section id="peringkat" class="py-32 bg-black/20">
        <div class="max-w-7xl mx-auto px-12 text-center">
            <div class="mb-20">
                <h2 class="text-5xl font-black uppercase italic tracking-tighter">Sistem <span class="text-[#ff4655]">Peringkat</span></h2>
                <p class="text-gray-500 text-[10px] font-bold tracking-[0.5em] uppercase mt-4">
                    // Pantau Progres Kamu Dari Iron Hingga Radiant //
                </p>
            </div>

            <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-9 gap-8">
                @foreach($currentEpisodeTiers as $tier)
                <div class="flex flex-col items-center group transition-transform hover:scale-110 tier-card">
                    <div class="w-16 h-16 mb-4 relative">
                        <div class="absolute inset-0 bg-[#ff4655]/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ $tier['largeIcon'] }}" class="w-full h-full object-contain relative z-10 drop-shadow-lg transition-all duration-300">
                    </div>
                    <span class="text-[8px] font-black uppercase tracking-widest text-center leading-tight text-gray-400 group-hover:text-white">
                        {{ $tier['tierName'] }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="mt-20 glass p-12 text-center border-t-2 border-[#ff4655]">
                <p class="text-sm italic text-gray-400 mb-8 max-w-2xl mx-auto">
                    "Setiap kemenangan membawa kamu satu langkah lebih dekat ke puncak Papan Peringkat Global ValoMaster. Siapkan strategimu sekarang."
                </p>
                <a href="{{ route('register') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-[#ff4655] hover:text-white transition group">
                    Bersaing Sekarang <span class="group-hover:translate-x-2 inline-block transition-transform">&rarr;</span>
                </a>
            </div>
        </div>
    </section>

    <footer class="p-12 border-t border-white/5 text-center">
        <p class="text-[10px] text-gray-600 font-bold uppercase tracking-[0.5em]">
            &copy; 2026 VALOMASTER PROJECT. ALL RIGHTS RESERVED.
        </p>
    </footer>

</body>
</html>