<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\EQIcontroller;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// EQI page — rendered by controller so pipeline runs automatically if needed
Route::get('/eqi', [EQIcontroller::class, 'index'])->name('eqi');

// JSON API — consumed by the EQI map/ranking JavaScript
Route::get('/api/eqi-data', [EQIcontroller::class, 'getData'])->name('eqi.data');
Route::post('/api/eqi-refresh', [EQIcontroller::class, 'refreshEqi'])->name('eqi.refresh');

Route::view('/prediction', 'prediction')->name('prediction');

Route::prefix('simulation')->name('simulation.')->group(function () {
    Route::get ('/', [SimulationController::class, 'index'])->name('index');
    Route::post('/hitung-eqi', [SimulationController::class, 'hitungEqi'])->name('hitung-eqi');
    Route::post('/what-if', [SimulationController::class, 'whatIf'])->name('what-if');
    Route::post('/sensitivity', [SimulationController::class, 'sensitivity'])->name('sensitivity');
});
