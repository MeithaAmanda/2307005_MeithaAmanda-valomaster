<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AgentController extends Controller
{
    /**
     * Menampilkan Halaman Explore (Agents, Maps, Weapons)
     */
    public function index(Request $request) {
        $search = $request->query('search');
        
        // Fetch data dari Valorant API
        $agentRes = Http::withoutVerifying()->get('https://valorant-api.com/v1/agents?isPlayableCharacter=true');
        $agents = $agentRes->successful() ? $agentRes->json()['data'] : [];
        
        // Logika Pencarian
        if ($search) {
            $agents = array_filter($agents, fn($a) => stripos($a['displayName'], $search) !== false);
        }

        $maps = Http::withoutVerifying()->get('https://valorant-api.com/v1/maps')->json()['data'];
        $weapons = Http::withoutVerifying()->get('https://valorant-api.com/v1/weapons')->json()['data'];

        return view('agents.index', compact('agents', 'maps', 'weapons'));
    }

    // Tambahkan fungsi ini di dalam class AgentController
    public function landing() {
    // Memanggil API Peringkat
    $response = Http::withoutVerifying()->get('https://valorant-api.com/v1/competitivetiers');
    $allTiers = $response->json()['data'];
    
    // Mengambil episode terbaru dan memfilter rank agar mulai dari Iron 1
    $currentEpisodeTiers = collect(end($allTiers)['tiers'])->filter(function($tier) {
        return $tier['tier'] > 2 && !str_contains($tier['tierName'], 'UNUSED');
    });

    // MENGIRIM VARIABEL KE VIEW [Inilah kunci agar tidak error]
    return view('landing', compact('currentEpisodeTiers'));
}

    /**
     * Menampilkan Koleksi Saya (Roster, Maps, Weapons)
     */
    public function myCollections() {
    $user_id = Auth::id();
    
    // 1. Ambil Data Koleksi dari Database
    $myAgents = DB::table('agent_pools')->where('user_id', $user_id)->get();
    $myMaps = DB::table('maps')->where('user_id', $user_id)->get();
    $myWeapons = DB::table('weapons')->where('user_id', $user_id)->get();

    // 2. Ambil Data Peringkat dari API untuk Pilihan Dropdown
    $response = Http::withoutVerifying()->get('https://valorant-api.com/v1/competitivetiers');
    $allTiers = $response->json()['data'];
    $currentEpisodeTiers = end($allTiers)['tiers']; 

    return view('agents.my_pool', compact('myAgents', 'myMaps', 'myWeapons', 'currentEpisodeTiers'));
    }

    /**
     * CRUD: Menyimpan Agen ke Roster
     */
    public function storeAgent(Request $request) {
    // 1. Cek apakah user ini sudah pernah memilih agen yang sama
    $duplikat = DB::table('agent_pools')
        ->where('user_id', Auth::id())
        ->where('agent_uuid', $request->agent_uuid)
        ->exists();

    // 2. Jika agen sudah ada, kirim pesan peringatan (Error)
    if ($duplikat) {
        return back()->with('error', 'Agen ' . $request->agent_name . ' agent sudah ada di koleksi kamu!');
    }

    // 3. Jika belum ada, baru simpan ke database
    DB::table('agent_pools')->insert([
        'user_id' => Auth::id(),
        'agent_uuid' => $request->agent_uuid,
        'agent_name' => $request->agent_name,
        'role' => $request->role,
        'image_url' => $request->image_url,
        'role_icon' => $request->role_icon,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Mantap! ' . $request->agent_name . ' agentberhasil ditambahkan');
    }

    /**
     * CRUD: Menyimpan Strategi Map
     */
    public function storeMap(Request $request) {
        DB::table('maps')->updateOrInsert(
            ['user_id' => Auth::id(), 'map_uuid' => $request->map_uuid],
            [
                'map_name' => $request->map_name,
                'map_image' => $request->map_image,
                'tactic_note' => $request->tactic_note,
                'updated_at' => now(),
            ]
        );
        return back()->with('success', 'Map berhasil ditambahkan!');
    }

    /**
     * CRUD: Menyimpan Weapon ke Wishlist
     */
    public function storeWeapon(Request $request) {
        DB::table('weapons')->insert([
            'user_id' => Auth::id(),
            'weapon_uuid' => $request->weapon_uuid,
            'weapon_name' => $request->weapon_name,
            'weapon_image' => $request->weapon_image,
            'category' => $request->category,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Senjata berhasil ditambahkan!');
    }

    /**
     * CRUD: Menghapus Agen
     */
    public function destroyAgent($id) {
        DB::table('agent_pools')->where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Agent berhasil dihapus dari koleksi');
    }

        /**
     * CRUD: Menghapus Strategi Map
     */
    public function destroyMap($id) {
        DB::table('maps')->where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Map berhasil dihapus dari koleksi');
    }

    /**
     * CRUD: Menghapus Weapon dari Wishlist
     */
    public function destroyWeapon($id) {
        DB::table('weapons')->where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Senjata berhasil dihapus dari koleksi');
    }

    /**
     * Profil & Update Rank
     */
    public function showProfile() {
        $response = Http::withoutVerifying()->get('https://valorant-api.com/v1/competitivetiers');
        $allTiers = $response->json()['data'];
        $currentEpisodeTiers = end($allTiers)['tiers']; 

        return view('profile', compact('currentEpisodeTiers'));
    }

    public function updateRank(Request $request) {
        User::where('id', Auth::id())->update([
            'rank_tier' => $request->tier_id,
            'rank_name' => $request->tier_name,
            'rank_icon' => $request->tier_icon,
        ]);
        return back()->with('success', 'rank berhasil diperbarui!');
    }

    /**
     * Leaderboard
     */
   public function leaderboard() {
    $topPlayers = DB::table('users')
        // TAMBAHKAN 'users.' di depan role
        ->where('users.role', '!=', 'admin') 
        ->leftJoin('agent_pools', function($join) {
            $join->on('users.id', '=', 'agent_pools.user_id')
                 ->whereRaw('agent_pools.id = (select max(id) from agent_pools where user_id = users.id)');
        })
        ->leftJoin('maps', function($join) {
            $join->on('users.id', '=', 'maps.user_id')
                 ->whereRaw('maps.id = (select max(id) from maps where user_id = users.id)');
        })
        ->leftJoin('weapons', function($join) {
            $join->on('users.id', '=', 'weapons.user_id')
                 ->whereRaw('weapons.id = (select max(id) from weapons where user_id = users.id)');
        })
        ->select(
            'users.*', 
            'agent_pools.image_url as fav_agent', 
            'agent_pools.agent_name as fav_agent_name', 
            'maps.map_image as fav_map', 
            'maps.map_name as fav_map_name',   
            'weapons.weapon_image as fav_weapon', 
            'weapons.weapon_name as fav_weapon_name' 
        )
        ->whereNotNull('rank_tier')
        ->orderBy('rank_tier', 'desc')
        ->get();

    return view('leader', compact('topPlayers'));
}
}