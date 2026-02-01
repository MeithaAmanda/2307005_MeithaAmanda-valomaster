<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;700;800&display=swap" rel="stylesheet">
    <style> 
        body { 
            font-family: 'Oxanium', sans-serif; 
            background-color: #0f1923; 
            color: white;
            background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.03) 1px, transparent 0);
            background-size: 40px 40px;
        }
        .glass-card { background: rgba(23, 33, 43, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
    <title>ValoMaster // Dashboard Saya</title>
</head>
<body>

    <nav class="sticky top-0 z-50 p-6 glass-card border-b border-white/10 flex justify-between items-center px-12">
        <div class="flex items-center">
            <h1 class="text-white font-black italic uppercase tracking-tighter text-2xl">Valo<span class="text-[#ff4655]">Master</span></h1>
        </div>
        <div class="flex items-center gap-10">
            <a href="{{ route('explore.index') }}" class="text-[10px] font-bold uppercase tracking-[0.3em] hover:text-[#ff4655] transition-all">Cari Agent</a>
            <a href="{{ route('leaderboard') }}" class="text-[10px] font-bold uppercase tracking-[0.3em] hover:text-[#ff4655] transition-all">Peringkat</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf 
                <button class="bg-[#ff4655] px-8 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all">Keluar</button>
            </form>
        </div>
    </nav>

    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="fixed top-24 right-10 z-[100] space-y-3">
        @if(session('success'))
            <div class="bg-green-600 text-white px-6 py-4 shadow-xl border-l-4 border-white animate-bounce">
                <div class="font-black uppercase text-xs tracking-widest">{{ session('success') }}</div>
            </div>
        @endif
    </div>

    <main class="max-w-7xl mx-auto px-6 py-12 space-y-20">
        
        <section class="glass-card p-10 flex flex-col md:flex-row items-center gap-12 rounded-sm">
            <div class="relative">
                <div class="absolute -inset-8 bg-[#ff4655]/10 blur-3xl rounded-full"></div>
                <img id="rankPreviewIcon" src="{{ Auth::user()->rank_icon ?? 'https://media.valorant-api.com/competitivetiers/03621bc4-4c1a-ad5e-26a9-0fc46274640d/0/largeicon.png' }}" 
                     class="w-32 h-32 relative z-10 drop-shadow-[0_0_15px_rgba(255,70,85,0.4)] object-contain">
            </div>
            
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-4xl font-black uppercase italic tracking-tighter">{{ Auth::user()->name }}</h2>
                <p id="rankPreviewName" class="text-[#ff4655] font-bold tracking-[0.4em] uppercase text-xs mt-2">
                    {{ Auth::user()->rank_name ?? 'Belum Ada Rank' }}
                </p>
            </div>

            <form action="{{ route('rank.update') }}" method="POST" class="w-full md:w-80">
                @csrf @method('PATCH')
                <label class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Pilih Rank Kamu:</label>
                <select name="rank_data" onchange="updateRankFields(this)" 
                        class="w-full bg-black/40 border border-white/10 p-3 text-[10px] font-bold uppercase tracking-widest text-white outline-none focus:border-[#ff4655] cursor-pointer">
                    <option value="">-- GANTI RANK --</option>
                    @foreach($currentEpisodeTiers as $tier)
                        @if($tier['tier'] > 2 && !str_contains($tier['tierName'], 'UNUSED'))
                        <option value="{{ $tier['tier'] }}" data-name="{{ $tier['tierName'] }}" data-icon="{{ $tier['largeIcon'] }}"
                                {{ Auth::user()->rank_tier == $tier['tier'] ? 'selected' : '' }}>
                            {{ $tier['tierName'] }}
                        </option>
                        @endif
                    @endforeach
                </select>
                <input type="hidden" name="tier_id" id="tier_id" value="{{ Auth::user()->rank_tier }}">
                <input type="hidden" name="tier_name" id="tier_name" value="{{ Auth::user()->rank_name }}">
                <input type="hidden" name="tier_icon" id="tier_icon" value="{{ Auth::user()->rank_icon }}">
                <button type="submit" class="w-full mt-3 bg-[#ff4655] py-3 text-[9px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all">Simpan Rank</button>
            </form>
        </section>

        <section>
            <div class="border-l-4 border-[#ff4655] pl-4 mb-8 flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-black uppercase italic leading-none">AGENT Saya</h2>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-2">// Agent yang sudah kamu pilih</p>
                </div>
                <span class="text-4xl font-black italic opacity-10">{{ count($myAgents) }}</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                @foreach($myAgents as $agent)
                <div class="glass-card p-6 flex flex-col items-center group relative overflow-hidden">
                    <img src="{{ $agent->image_url }}" class="w-20 h-20 mb-4 group-hover:scale-110 transition duration-500">
                    <h4 class="text-sm font-black uppercase italic text-center leading-tight">{{ $agent->agent_name }}</h4>
                    <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" class="mt-4 w-full">
                        @csrf @method('DELETE')
                        <button class="w-full py-2 text-[7px] font-bold border border-white/10 hover:bg-[#ff4655] hover:text-white transition uppercase">Hapus</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <section>
                <div class="border-l-4 border-[#ff4655] pl-4 mb-8">
                    <h2 class="text-2xl font-black uppercase italic">Info MAPS</h2>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-1">// Catatan strategi kamu</p>
                </div>
                <div class="space-y-4">
                    @foreach($myMaps as $map)
                    <div class="glass-card flex overflow-hidden h-28">
                        <img src="{{ $map->map_image }}" class="w-28 object-cover opacity-50">
                        <div class="p-4 flex-1 flex flex-col justify-center">
                            <h4 class="text-lg font-black uppercase italic text-[#ff4655]">{{ $map->map_name }}</h4>
                            <p class="text-[10px] text-gray-400 italic line-clamp-1">"{{ $map->tactic_note }}"</p>
                            <form action="{{ route('maps.destroy', $map->id) }}" method="POST" class="mt-2">
                                @csrf @method('DELETE')
                                <button class="text-[7px] font-bold uppercase text-gray-600 hover:text-white transition">Hapus Info</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <section>
                <div class="border-l-4 border-[#ff4655] pl-4 mb-8">
                    <h2 class="text-2xl font-black uppercase italic">Koleksi Senjata</h2>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-1">// Daftar senjata favorit kamu</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($myWeapons as $weapon)
                    <div class="glass-card p-4 flex items-center gap-4 relative group">
                        <img src="{{ $weapon->weapon_image }}" class="h-8 group-hover:scale-110 transition duration-500">
                        <div class="flex-1">
                            <h4 class="text-[9px] font-black uppercase leading-tight">{{ $weapon->weapon_name }}</h4>
                            <form action="{{ route('weapons.destroy', $weapon->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-[7px] font-bold uppercase text-gray-600 hover:text-[#ff4655] transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
    </main>

    <script>
    function updateRankFields(select) {
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption.value !== "") {
            const name = selectedOption.getAttribute('data-name');
            const icon = selectedOption.getAttribute('data-icon');
            document.getElementById('tier_id').value = select.value;
            document.getElementById('tier_name').value = name;
            document.getElementById('tier_icon').value = icon;
            document.getElementById('rankPreviewIcon').src = icon;
            document.getElementById('rankPreviewName').innerText = name;
        }
    }
    </script>
</body>
</html>