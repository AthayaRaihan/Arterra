<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulationController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::view('/eqi', 'EQI')->name('eqi');
Route::view('/prediction', 'prediction')->name('prediction');

Route::prefix('simulation')->name('simulation.')->group(function () {
    Route::get ('/', [SimulationController::class, 'index'])->name('index');
    Route::post('/hitung-eqi', [SimulationController::class, 'hitungEqi'])->name('hitung-eqi');
    Route::post('/what-if', [SimulationController::class, 'whatIf'])->name('what-if');
    Route::post('/sensitivity', [SimulationController::class, 'sensitivity'])->name('sensitivity');
});
