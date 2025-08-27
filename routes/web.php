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
Route::get('/admin/login', [App\Http\Controllers\AuthController::class, 'index'])->name('login'); 
Route::resource('/admin/clientes', App\Http\Controllers\ClienteController::class); 
Route::resource('/admin/categorias', App\Http\Controllers\CategoriaController::class); 
Route::resource('/admin/produtos', App\Http\Controllers\ProdutoController::class); 
Route::resource('/admin/agendamentos', App\Http\Controllers\AgendamentoController::class); 
Route::resource('/admin/configuracoes', App\Http\Controllers\ConfiguracaoController::class)->parameters(['configuracoes' => 'configuracao']); 

// Financeiro
Route::resource('/admin/categorias-financeiras', App\Http\Controllers\CategoriaFinanceiraController::class)->parameters(['categorias-financeiras' => 'categoriaFinanceira']); 
Route::resource('/admin/formas-pagamento', App\Http\Controllers\FormaPagamentoController::class)->parameters(['formas-pagamento' => 'formaPagamento']); 
Route::resource('/admin/financeiro', App\Http\Controllers\MovimentacaoFinanceiraController::class)->parameters(['financeiro' => 'movimentacao']); 



Route::get('/dashboard', function(){
    return view('admin.dashboard');
})->name('admin.dashboard'); 

