<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::view('/eqi', 'EQI')->name('eqi');
Route::view('/prediction', 'prediction')->name('prediction');
Route::view('/simulation', 'simulation')->name('simulation');
