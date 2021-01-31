<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Salles;
use App\Http\Livewire\Reservations;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});





Route::middleware(['auth:sanctum', 'verified'])->prefix('/')->group(function () {
    
    Route::get('salles', Salles::class)->name('salles');
    Route::get('reservations', Reservations::class)->name('reservations');
    Route::get('/dashboard', [Controller::class,'dashboard'])->name('dashboard');
});