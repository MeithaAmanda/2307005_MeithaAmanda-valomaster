<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Oxanium', sans-serif; background-color: #0f1923; color: white; }
        .leaderboard-row:hover { background-color: rgba(255, 70, 85, 0.05); border-left: 6px solid #ff4655; }
        .fav-icon { width: 56px; height: 56px; object-fit: contain; filter: drop-shadow(0 0 8px rgba(255,70,85,0.4)); }
    </style>
    <title>VALOMASTER // Papan Peringkat</title>
</head>
<body class="selection:bg-[#ff4655] selection:text-white">

    <nav class="sticky top-0 z-50 p-6 border-b border-white/10 bg-[#0f1923]/95 backdrop-blur-md flex justify-between items-center px-12">
        <h1 class="text-white font-black italic uppercase tracking-tighter text-3xl">Valo<span class="text-[#ff4655]">Master</span></h1>
        <div class="flex items-center gap-10">
            <a href="{{ route('explore.index') }}" class="text-xs font-bold uppercase tracking-[0.2em] hover:text-[#ff4655] transition">Cari agent</a>
            <a href="{{ route('collections.index') }}" class="text-xs font-bold uppercase tracking-[0.2em] hover:text-[#ff4655] transition">Koleksi Saya</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf 
                <button class="bg-[#ff4655] px-8 py-3 text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-black transition">Keluar</button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-24">
        <div class="mb-20 text-center">
            <h2 class="text-7xl font-black uppercase italic tracking-tighter">Papan <span class="text-[#ff4655]">Peringkat</span></h2>
            <p class="text-gray-500 text-xs font-bold tracking-[0.5em] uppercase mt-6 opacity-60">
                // Analisis Performa Pemain Terbaik //
            </p>
        </div>

        <div class="bg-[#17212b] border border-white/5 shadow-[0_0_50px_rgba(0,0,0,0.5)] overflow-hidden rounded-sm">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-black/40 text-[#ff4655] text-xs uppercase font-black tracking-[0.3em] border-b border-white/10">
                        <th class="p-8">No.</th>
                        <th class="p-8">Pemain</th>
                        <th class="p-8 text-center">Rank</th>
                        <th class="p-8 text-center">Agent Utama</th>
                        <th class="p-8 text-center">Map Favorit</th>
                        <th class="p-8 text-center">Senjata Favorit</th>
                    </tr>
                </thead>
                <tbody class="text-base">
    @forelse($topPlayers as $index => $player)
    <tr class="leaderboard-row border-b border-white/5 transition-all duration-300 {{ $player->id == Auth::id() ? 'bg-[#ff4655]/10 border-l-4 border-[#ff4655]' : '' }}">
        <td class="p-8">
            <span class="text-4xl font-black italic opacity-20">#{{ $index + 1 }}</span>
        </td>
        <td class="p-8">
            <div class="flex items-center gap-6">
                <img src="{{ $player->rank_icon }}" class="w-16 h-16 object-contain">
                <div>
                    <p class="text-xl font-black uppercase tracking-tight text-white leading-none">{{ $player->name }}</p>
                </div>
            </div>
        </td>
        <td class="p-8 text-center">
            <span class="text-xs font-black uppercase italic text-[#ff4655] border border-[#ff4655]/30 bg-[#ff4655]/5 px-4 py-2">
                {{ $player->rank_name }}
            </span>
        </td>
        
        <td class="p-8 text-center">
            @if($player->fav_agent)
                <img src="{{ $player->fav_agent }}" class="fav-icon inline-block scale-125">
                <p class="text-[9px] font-bold uppercase mt-3 text-gray-400 tracking-widest">{{ $player->fav_agent_name }}</p>
            @else
                <span class="text-[10px] opacity-20 italic">Belum Ada</span>
            @endif
        </td>

        <td class="p-8 text-center">
            @if($player->fav_map)
                <img src="{{ $player->fav_map }}" class="fav-icon inline-block rounded-lg border-2 border-white/10 shadow-lg">
                <p class="text-[9px] font-bold uppercase mt-3 text-gray-400 tracking-widest">{{ $player->fav_map_name }}</p>
            @else
                <span class="text-[10px] opacity-20 italic">Belum Ada</span>
            @endif
        </td>

        <td class="p-8 text-center">
            @if($player->fav_weapon)
                <img src="{{ $player->fav_weapon }}" class="fav-icon inline-block">
                <p class="text-[9px] font-bold uppercase mt-3 text-gray-400 tracking-widest">{{ $player->fav_weapon_name }}</p>
            @else
                <span class="text-[10px] opacity-20 italic">Belum Ada</span>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="p-8 text-center text-gray-500 italic">Tidak ada pemain yang terdaftar.</td>
    </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </main>

</body>
</html>