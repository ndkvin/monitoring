<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/export', [App\Http\Controllers\HomeController::class, 'export'])->name('export');
Route::post('/export-year', [App\Http\Controllers\HomeController::class, 'exportYear'])->name('export-year');
Route::resource('fuel', App\Http\Controllers\FuelController::class)->except(['index','edit', 'create']);