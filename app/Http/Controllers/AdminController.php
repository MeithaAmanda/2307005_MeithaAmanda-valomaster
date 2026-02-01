<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Map;
use App\Models\Weapon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
{
    
    if (Auth::user()->role !== 'admin') {
        return redirect('/explore')->with('error', 'Akses ditolak!');
    }

    $userList = User::where(function($query) {
            $query->where('role', 'user')
                  ->orWhereNull('role');
        })
        ->where('id', '!=', Auth::user()->id) 
        ->withCount(['maps', 'weapons'])
        ->get();

    
    $totalUsers = User::where('role', '!=', 'admin')->count();
    $totalEnlisted = DB::table('agent_pools')->count();
    $totalMaps = Map::count();
    $totalWeapons = Weapon::count();

    
    $topMap = Map::select('map_name', DB::raw('count(*) as total'))
        ->groupBy('map_name')
        ->orderBy('total', 'desc')
        ->first();
    $topMapCount = $topMap ? $topMap->total : 0;

    
    $topWeapon = Weapon::select('weapon_name', DB::raw('count(*) as total'))
        ->groupBy('weapon_name')
        ->orderBy('total', 'desc')
        ->first();
    $topWeaponCount = $topWeapon ? $topWeapon->total : 0;

    
    $topAgent = DB::table('agent_pools')
        ->select('agent_name', DB::raw('count(*) as total'))
        ->groupBy('agent_name')
        ->orderBy('total', 'desc')
        ->first();
            
    
    foreach ($userList as $user) {
        $user->agent_pools_count = DB::table('agent_pools')->where('user_id', $user->id)->count();
    }

    return view('admin.dashboard', compact(
        'totalUsers', 'totalEnlisted', 'totalMaps', 'totalWeapons',
        'topMap', 'topMapCount', 'topWeapon', 'topWeaponCount', 
        'topAgent', 'userList'
    ));
}
}