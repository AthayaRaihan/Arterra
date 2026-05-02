<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\EQIcontroller;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $data = \App\Models\EduQuality::whereNotNull('eqi_score')->get();
        
        $totalWilayah = $data->count();
        $rataRataEqi = $data->avg('eqi_score');
        $terbaik = $data->sortByDesc('eqi_score')->first();
        $terendah = $data->sortBy('eqi_score')->first();
        
        $distribusi = [
            'Sangat Baik' => $data->where('kategori', 'Sangat Baik')->count(),
            'Baik' => $data->where('kategori', 'Baik')->count(),
            'Cukup' => $data->where('kategori', 'Cukup')->count(),
            'Rendah' => $data->where('kategori', 'Rendah')->count(),
        ];

        return view('dashboard', compact('totalWilayah', 'rataRataEqi', 'terbaik', 'terendah', 'distribusi'));
    })->name('dashboard');

    // EQI page — rendered by controller so pipeline runs automatically if needed
    Route::get('/eqi', [EQIcontroller::class, 'index'])->name('eqi');

    // JSON API — consumed by the EQI map/ranking JavaScript
    Route::get('/api/eqi-data', [EQIcontroller::class, 'getData'])->name('eqi.data');
    Route::post('/api/eqi-refresh', [EQIcontroller::class, 'refreshEqi'])->name('eqi.refresh');

    Route::view('/prediction', 'prediction')->name('prediction');

    Route::prefix('simulation')->name('simulation.')->group(function () {
        Route::get ('/', [SimulationController::class, 'index'])->name('index');
        Route::get ('/kabupaten-data', [SimulationController::class, 'getKabupatenData'])->name('kabupaten-data');
        Route::post('/hitung-eqi', [SimulationController::class, 'hitungEqi'])->name('hitung-eqi');
        Route::post('/what-if', [SimulationController::class, 'whatIf'])->name('what-if');
        Route::post('/sensitivity', [SimulationController::class, 'sensitivity'])->name('sensitivity');
    });
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
