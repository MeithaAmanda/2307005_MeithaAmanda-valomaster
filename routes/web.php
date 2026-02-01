<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// halaman landing
Route::get('/', [AgentController::class, 'landing'])->name('landing');

// Rute Login dan Register 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// khusus authenticated user
Route::middleware(['auth'])->group(function () {
    
    // navigasi Utama
    Route::get('/explore', [AgentController::class, 'index'])->name('explore.index');
    Route::get('/my-collections', [AgentController::class, 'myCollections'])->name('collections.index');
    Route::get('/leaderboard', [AgentController::class, 'leaderboard'])->name('leaderboard');
    
    // update Peringkat
    Route::patch('/profile/rank', [AgentController::class, 'updateRank'])->name('rank.update');
    
    // proses Simpan 
    Route::post('/save-agent', [AgentController::class, 'storeAgent'])->name('agents.store');
    Route::post('/save-map', [AgentController::class, 'storeMap'])->name('maps.store');
    Route::post('/save-weapon', [AgentController::class, 'storeWeapon'])->name('weapons.store');
    
    // proses Hapus
    Route::delete('/agent/{id}', [AgentController::class, 'destroyAgent'])->name('agents.destroy');
    Route::delete('/map/{id}', [AgentController::class, 'destroyMap'])->name('maps.destroy');
    Route::delete('/weapon/{id}', [AgentController::class, 'destroyWeapon'])->name('weapons.destroy');
    
    // keluar
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin-panel', [AdminController::class, 'index'])->name('admin.dashboard');
});