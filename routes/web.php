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
Route::get('/', [App\Http\Controllers\AuthController::class, 'index'])->name('login'); 
Route::get('/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('clientes.index'); 
Route::get('/dashboard', function(){
    return view('admin.dashboard');
})->name('admin.dashboard'); 

