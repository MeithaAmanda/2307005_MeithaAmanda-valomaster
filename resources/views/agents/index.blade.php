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
        .valorant-gradient { background: linear-gradient(180deg, rgba(255,70,85,0.05) 0%, rgba(15,25,35,1) 100%); }
        .glass { background: rgba(23, 33, 43, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .agent-card:hover .agent-img { transform: scale(1.1) translateY(-10px); filter: drop-shadow(0 0 20px rgba(255, 70, 85, 0.4)); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #ff4655; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
    <title>VALOMASTER // Dashboard Utama</title>
</head>
<body class="selection:bg-[#ff4655] selection:text-white" x-data="{ tab: 'agents' }">

    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 4000)"
         class="fixed top-24 right-10 z-[100] space-y-3">
        @if(session('success'))
        <div class="bg-green-600 text-white px-6 py-4 shadow-xl border-l-4 border-white animate-bounce">
            <div class="font-black uppercase text-xs tracking-widest">
                {{ session('success') }}
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="bg-[#ff4655] text-white px-6 py-4 shadow-xl border-l-4 border-white">
            <div class="font-black uppercase text-xs tracking-widest">
                {{ session('error') }}
            </div>
        </div>
        @endif
    </div>

    <nav class="sticky top-0 z-50 p-6 glass border-b border-white/10 flex justify-between items-center px-12">
        <div class="flex items-center gap-2">
            <h1 class="text-white font-black italic uppercase tracking-tighter text-2xl ml-2">Valo<span class="text-[#ff4655]">Master</span></h1>
        </div>
        <div class="flex items-center gap-10">
            <a href="{{ route('collections.index') }}" class="text-[10px] font-bold uppercase tracking-[0.3em] hover:text-[#ff4655] transition-all">Koleksi Saya</a>
            <a href="{{ route('leaderboard') }}" class="text-[10px] font-bold uppercase tracking-[0.3em] hover:text-[#ff4655] transition-all">Peringkat</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf 
                <button class="bg-[#ff4655] px-8 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all">Keluar</button>
            </form>
        </div>
    </nav>

    <header class="relative h-[45vh] flex flex-col items-center justify-center overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 valorant-gradient opacity-60"></div>
        <div class="relative z-10 text-center px-6">
            <p class="text-[10px] font-black tracking-[0.6em] text-[#ff4655] uppercase mb-4 animate-pulse">// Selamat Datang, {{ Auth::user()->name }}! //</p>
            <h1 class="text-7xl md:text-8xl font-black italic uppercase tracking-tighter leading-none mb-6">
                <span x-show="tab === 'agents'" x-transition:enter="transition ease-out duration-300">PILIH <span class="text-[#ff4655]">AGENT</span></span>
                <span x-show="tab === 'maps'" x-transition:enter="transition ease-out duration-300" x-cloak>INFO <span class="text-[#ff4655]">MAPS</span></span>
                <span x-show="tab === 'weapons'" x-transition:enter="transition ease-out duration-300" x-cloak>DAFTAR <span class="text-[#ff4655]">SENJATA</span></span>
            </h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        
        <div class="flex justify-center gap-6 mb-20">
            <button @click="tab = 'agents'" :class="tab === 'agents' ? 'text-white border-[#ff4655] bg-white/5' : 'text-gray-500 border-transparent'" class="pb-4 px-12 border-b-2 font-black uppercase text-sm tracking-widest transition-all">AGENT</button>
            <button @click="tab = 'maps'" :class="tab === 'maps' ? 'text-white border-[#ff4655] bg-white/5' : 'text-gray-500 border-transparent'" class="pb-4 px-12 border-b-2 font-black uppercase text-sm tracking-widest transition-all">MAPS</button>
            <button @click="tab = 'weapons'" :class="tab === 'weapons' ? 'text-white border-[#ff4655] bg-white/5' : 'text-gray-500 border-transparent'" class="pb-4 px-12 border-b-2 font-black uppercase text-sm tracking-widest transition-all">Senjata</button>
        </div>

        <div x-show="tab === 'agents'" x-transition x-cloak>
            <div class="mb-12 flex flex-col md:flex-row justify-between items-end gap-6">
                <div>
                    <h3 class="text-2xl font-black italic uppercase tracking-tight">Cari <span class="text-[#ff4655]">Jagoanmu</span></h3>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">// Tambahkan AGENT ke dalam daftar favoritmu</p>
                </div>
                <form action="{{ route('explore.index') }}" method="GET" class="w-full md:w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="CARI NAMA AGENT..." 
                           class="w-full bg-white/5 border-b border-white/20 py-4 px-6 focus:outline-none focus:border-[#ff4655] text-sm font-bold uppercase">
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($agents as $agent)
                <div class="agent-card glass group relative p-8 transition-all hover:border-[#ff4655]/50 flex flex-col items-center">
                    <span class="absolute top-6 left-6 text-[8px] font-black text-[#ff4655] tracking-[0.3em] uppercase bg-[#ff4655]/10 px-3 py-1 border border-[#ff4655]/20">
                        {{ $agent['role']['displayName'] ?? 'Rahasia' }}
                    </span>
                    
                    <div class="relative w-48 h-48 mb-6">
                        <img src="{{ $agent['displayIcon'] }}" class="agent-img w-full h-full relative z-10 transition-all duration-500 grayscale group-hover:grayscale-0">
                    </div>

                    <h3 class="text-3xl font-black uppercase italic mb-8">{{ $agent['displayName'] }}</h3>
                    
                    <div class="flex flex-col gap-2 w-full mt-auto">
                        <button onclick='openModal(@json($agent))' class="w-full py-3 border border-white/10 text-[9px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition">Lihat Detail</button>
                        <form action="{{ route('agents.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="agent_uuid" value="{{ $agent['uuid'] }}">
                            <input type="hidden" name="agent_name" value="{{ $agent['displayName'] }}">
                            <input type="hidden" name="role" value="{{ $agent['role']['displayName'] ?? 'Rahasia' }}">
                            <input type="hidden" name="image_url" value="{{ $agent['displayIcon'] }}">
                            <input type="hidden" name="role_icon" value="{{ $agent['role']['displayIcon'] ?? '' }}">
                            <button class="w-full py-3 bg-[#ff4655] text-white font-black uppercase text-[9px] tracking-widest">Tambah ke Koleksi Saya</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div x-show="tab === 'maps'" x-transition x-cloak>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                @foreach($maps as $map)
                <div class="group relative bg-[#17212b] border border-white/5 overflow-hidden shadow-2xl h-[400px]">
                    <img src="{{ $map['splash'] }}" class="w-full h-full object-cover opacity-40 group-hover:opacity-100 transition-all duration-700">
                    <div class="absolute inset-0 p-12 flex flex-col justify-end bg-gradient-to-t from-[#0f1923] via-[#0f1923]/20">
                        <h4 class="text-6xl font-black uppercase italic tracking-tighter mb-6">{{ $map['displayName'] }}</h4>
                        <form action="{{ route('maps.store') }}" method="POST" class="flex items-center gap-4 bg-black/40 p-2 border border-white/10">
                            @csrf
                            <input type="hidden" name="map_uuid" value="{{ $map['uuid'] }}">
                            <input type="hidden" name="map_name" value="{{ $map['displayName'] }}">
                            <input type="hidden" name="map_image" value="{{ $map['splash'] }}">
                            <input type="text" name="tactic_note" placeholder="TULIS CATATAN STRATEGI..." class="flex-1 bg-transparent py-2 px-4 text-[10px] font-bold uppercase tracking-widest focus:outline-none">
                            <button class="bg-[#ff4655] px-8 py-3 text-[10px] font-black uppercase">TAMBAH KE KOLEKSI SAYA</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div x-show="tab === 'weapons'" x-transition x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($weapons as $weapon)
                <div class="glass p-10 flex flex-col items-center group">
                    <div class="h-32 flex items-center mb-8">
                        <img src="{{ $weapon['displayIcon'] }}" class="max-w-full h-auto drop-shadow-lg group-hover:scale-110 transition-transform">
                    </div>
                    <h4 class="text-2xl font-black uppercase italic mb-1">{{ $weapon['displayName'] }}</h4>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mb-8">// Kategori: {{ $weapon['category'] }}</p>
                    
                    <form action="{{ route('weapons.store') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="weapon_uuid" value="{{ $weapon['uuid'] }}">
                        <input type="hidden" name="weapon_name" value="{{ $weapon['displayName'] }}">
                        <input type="hidden" name="weapon_image" value="{{ $weapon['displayIcon'] }}">
                        <input type="hidden" name="category" value="{{ $weapon['category'] }}">
                        <button class="w-full py-4 border border-white/5 text-[9px] font-black uppercase tracking-widest hover:bg-white hover:text-black">TAMBAH KE KOLEKSI SAYA</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <div id="agentModal" class="modal opacity-0 pointer-events-none fixed inset-0 flex items-center justify-center z-[100] p-6 transition-all duration-500">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-xl" onclick="closeModal()"></div>
        <div class="modal-container bg-[#17212b] w-full max-w-5xl h-[80vh] overflow-hidden relative border border-white/10">
            <div class="flex flex-col md:flex-row h-full">
                <div class="md:w-2/5 bg-[#0f1923] p-16 flex flex-col items-center justify-center border-r border-white/5">
                    <img id="modalIcon" src="" class="w-64 h-64 drop-shadow-[0_0_50px_rgba(255,70,85,0.3)] mb-10">
                    <h2 id="modalTitle" class="text-7xl font-black uppercase italic text-white"></h2>
                    <span id="modalRole" class="mt-4 text-[11px] font-black tracking-widest uppercase text-[#ff4655]"></span>
                </div>
                <div class="md:w-3/5 p-16 overflow-y-auto custom-scrollbar">
                    <div class="mb-12">
                        <h4 class="text-[10px] font-black text-[#ff4655] tracking-widest uppercase mb-4 opacity-50 italic">// Biografi</h4>
                        <p id="modalDesc" class="text-gray-400 text-base italic leading-relaxed"></p>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black text-[#ff4655] tracking-widest uppercase mb-8 opacity-50 italic">// Kemampuan Khusus</h4>
                        <div id="modalAbilities" class="grid gap-6"></div>
                    </div>
                </div>
            </div>
            <button onclick="closeModal()" class="absolute top-8 right-8 text-white/20 hover:text-[#ff4655] text-4xl">&times;</button>
        </div>
    </div>

    <script>
        function openModal(agent) {
            document.getElementById('modalTitle').innerText = agent.displayName;
            document.getElementById('modalDesc').innerText = agent.description;
            document.getElementById('modalIcon').src = agent.displayIcon;
            document.getElementById('modalRole').innerText = agent.role ? agent.role.displayName : 'RAHASIA';
            
            const container = document.getElementById('modalAbilities');
            container.innerHTML = '';
            agent.abilities.forEach(ability => {
                if(ability.displayIcon) {
                    container.innerHTML += `
                        <div class="flex gap-6 items-start bg-white/5 p-6 border border-white/5">
                            <img src="${ability.displayIcon}" class="w-14 h-14 p-2 bg-black/40 border border-white/10">
                            <div>
                                <h5 class="text-sm font-black uppercase italic text-[#ff4655] mb-2">${ability.displayName}</h5>
                                <p class="text-xs text-gray-500 leading-relaxed">${ability.description}</p>
                            </div>
                        </div>`;
                }
            });
            document.getElementById('agentModal').classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('agentModal').classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>