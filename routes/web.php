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
Route::get('/', [App\Http\Controllers\SiteController::class, 'index'])->name('site.home');
Route::get('/site', function(){
    return view('site');
});

Route::get('/agendamento', [App\Http\Controllers\SiteController::class, 'agendamento'])->name('site.agendamento');
Route::post('/agendamento', [App\Http\Controllers\SiteController::class, 'salvarAgendamento'])->name('site.agendamento.salvar');

// Admin
Route::get('/admin/login', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/entrar', [ App\Http\Controllers\AuthController::class, 'entrar'])->name('login.entrar');

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [ App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard'); 

    Route::resource('/admin/clientes', App\Http\Controllers\ClienteController::class); 
    Route::resource('/admin/categorias', App\Http\Controllers\CategoriaController::class);  
    Route::resource('/admin/produtos', App\Http\Controllers\ProdutoController::class); 
    Route::resource('/admin/agendamentos', App\Http\Controllers\AgendamentoController::class); 
    Route::resource('/admin/configuracoes', App\Http\Controllers\ConfiguracaoController::class)->parameters(['configuracoes' => 'configuracao']); 

    // Financeiro
    Route::resource('/admin/categorias-financeiras', App\Http\Controllers\CategoriaFinanceiraController::class)->parameters(['categorias-financeiras' => 'categoriaFinanceira']); 
    Route::resource('/admin/formas-pagamento', App\Http\Controllers\FormaPagamentoController::class)->parameters(['formas-pagamento' => 'formaPagamento']); 
    Route::resource('/admin/financeiro', App\Http\Controllers\MovimentacaoFinanceiraController::class)->parameters(['financeiro' => 'movimentacao']); 
    Route::put('/admin/financeiro/{financeiro}/cancelar', [App\Http\Controllers\MovimentacaoFinanceiraController::class,'cancelar']); 
    Route::put('/admin/financeiro/{financeiro}/baixar', [App\Http\Controllers\MovimentacaoFinanceiraController::class, 'baixar']); 


    Route::post('/agendamentos/{id}/associar', [App\Http\Controllers\AgendamentoController::class, 'associarSlot']);
    Route::post('/agendamentos/gerar-lote', [App\Http\Controllers\AgendamentoController::class, 'gerarEmLote'])->name('agendamentos.gerar-lote');

    Route::post('/admin/agendamentos/{agendamento}/cancelar', [App\Http\Controllers\AgendamentoController::class, 'cancelarAtendimento'])->name('agendamentos.cancelar-atendimento');
    Route::post('/admin/agendamentos/{agendamento}/mudar-status', [App\Http\Controllers\AgendamentoController::class, 'mudarStatus'])->name('agendamentos.mudar-status');
    Route::post('/admin/agendamentos/{agendamento}/iniciar', [App\Http\Controllers\AgendamentoController::class, 'iniciarAtendimento'])->name('agendamentos.iniciar-atendimento');
    Route::post('/admin/agendamentos/{agendamento}/finalizar', [App\Http\Controllers\AgendamentoController::class, 'finalizarAtendimento'])->name('agendamentos.finalizar-atendimento');
    
    // Usuários
    Route::resource('/admin/users', App\Http\Controllers\UserController::class);
    Route::get('/admin/perfil', [App\Http\Controllers\UserController::class, 'perfilIndex'])->name('perfilindex');
});
