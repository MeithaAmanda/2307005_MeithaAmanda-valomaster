<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Oxanium', sans-serif; background-color: #0f1923; color: white; }
        .glass { background: rgba(23, 33, 43, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
    <title>ValoMaster // Panel Manajemen Data</title>
</head>
<body>

    <nav class="sticky top-0 z-50 p-6 glass border-b border-white/10 flex justify-between items-center px-12">
        <h1 class="text-white font-black italic uppercase text-2xl">Valo<span class="text-[#ff4655]">Master</span></h1>
        <div class="flex items-center gap-8">
            <span class="text-[10px] font-bold text-green-500 uppercase tracking-widest">● Sistem Aktif</span>
            <a href="{{ route('explore.index') }}" class="text-[10px] font-bold uppercase tracking-widest hover:text-[#ff4655] transition">Beranda Utama</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf 
                <button class="bg-[#ff4655] px-6 py-2 text-[10px] font-black uppercase tracking-widest">Keluar</button>
            </form>
        </div>
    </nav>

    <header class="relative h-[35vh] flex flex-col items-center justify-center border-b border-white/5">
        <div class="text-center px-6">
            <p class="text-[10px] font-black tracking-[0.5em] text-[#ff4655] uppercase mb-4">// Panel Manajemen Pusat //</p>
            <h1 class="text-6xl font-black italic uppercase tracking-tighter">RINGKASAN <span class="text-[#ff4655]">DATA</span></h1>
            <p class="text-gray-500 text-xs font-bold uppercase mt-4">Administrator: {{ Auth::user()->name }}</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
            <div class="glass p-8 border-l-4 border-[#ff4655]">
                <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Total Pengguna</span>
                <h3 class="text-4xl font-black mt-2">{{ $totalUsers }}</h3>
            </div>
            <div class="glass p-8 border-l-4 border-white/20">
                <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Karakter Terpilih</span>
                <h3 class="text-4xl font-black mt-2">{{ $totalEnlisted }}</h3>
            </div>
            <div class="glass p-8 border-l-4 border-blue-500">
                <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Data Area</span>
                <h3 class="text-4xl font-black mt-2">{{ $totalMaps }}</h3>
            </div>
            <div class="glass p-8 border-l-4 border-green-500">
                <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Total Senjata</span>
                <h3 class="text-4xl font-black mt-2">{{ $totalWeapons }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            <div class="glass p-10 flex justify-between items-center border-r-4 border-yellow-500/50">
                <div>
                    <span class="text-[10px] text-yellow-500 uppercase font-black tracking-widest">Area Terfavorit</span>
                    <h3 class="text-3xl font-black mt-2 uppercase italic">{{ $topMap ? $topMap->map_name : 'N/A' }}</h3>
                </div>
                <p class="text-4xl font-black text-white/10">{{ $topMapCount }} Simpanan</p>
            </div>
            <div class="glass p-10 flex justify-between items-center border-r-4 border-[#ff4655]/50">
                <div>
                    <span class="text-[10px] text-[#ff4655] uppercase font-black tracking-widest">Senjata Paling Dicari</span>
                    <h3 class="text-3xl font-black mt-2 uppercase italic">{{ $topWeapon ? $topWeapon->weapon_name : 'N/A' }}</h3>
                </div>
                <p class="text-4xl font-black text-white/10">{{ $topWeaponCount }} Koleksi</p>
            </div>
        </div>

        <div class="mb-12">
            <h3 class="text-2xl font-black italic uppercase mb-8">Direktori <span class="text-[#ff4655]">Pengguna</span></h3>
            <div class="glass overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-black/40 text-[#ff4655] text-[10px] uppercase font-black tracking-widest border-b border-white/10">
                            <th class="p-6">Identitas Pengguna</th>
                            <th class="p-6 text-center">Peringkat Akun</th>
                            <th class="p-6 text-center">Metrik Aset (K/P/S)</th>
                            <th class="p-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                       <tbody class="text-sm">
                        @forelse($userList as $u)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-all group">
                            </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center opacity-30 font-black italic uppercase tracking-widest text-sm">
                                Belum ada data personil yang terdaftar dalam direktori.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="p-12 border-t border-white/5 text-center mt-20 italic">
        <p class="text-[10px] text-gray-600 font-bold uppercase tracking-[0.5em]">
            &copy; 2026 VALOMASTER. All Rights Reserved.
        </p>
    </footer>

</body>
</html>