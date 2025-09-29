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
Route::get('/api/slots-disponiveis', [App\Http\Controllers\SiteController::class, 'getSlotsDisponiveis'])->name('api.slots-disponiveis');
Route::get('/api/servicos-por-filial/{filialId}', [App\Http\Controllers\SiteController::class, 'getServicosPorFilial'])->name('api.servicos-por-filial');
Route::get('/api/produtos-por-filial/{filialId}', [App\Http\Controllers\SiteController::class, 'getProdutosPorFilial'])->name('api.produtos-por-filial');
Route::post('/api/finalizar-agendamento-completo', [App\Http\Controllers\SiteController::class, 'finalizarAgendamentoCompleto'])->name('api.finalizar-agendamento-completo');
// Admin
Route::get('/admin/login', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/entrar', [ App\Http\Controllers\AuthController::class, 'entrar'])->name('login.entrar');

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [ App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard'); 

    // Filiais
    Route::resource('/admin/filiais', App\Http\Controllers\FilialController::class)->parameters(['filiais' => 'filial']);;
    
    // Fornecedores
    Route::resource('/admin/fornecedores',  App\Http\Controllers\FornecedorController::class)->parameters(['fornecedores' => 'fornecedor']);;

    // Barbeiros
    Route::resource('admin/barbeiros', App\Http\Controllers\BarbeiroController::class);
    Route::get('barbeiros/{barbeiro}/filiais', [App\Http\Controllers\BarbeiroController::class, 'getFiliais'])->name('barbeiros.filiais');
    Route::post('barbeiros/{barbeiro}/vincular-filial', [App\Http\Controllers\BarbeiroController::class, 'vincularFilial'])->name('barbeiros.vincular-filial');
    Route::post('/barbeiros/{barbeiro}/desvincular-filial', [App\Http\Controllers\BarbeiroController::class, 'desvincularFilial'])->name('barbeiros.desvincular-filial');
    
    // Admin routes for comissions
    Route::get('/admin/comissoes/{barbeiro}/{filial}', [App\Http\Controllers\ComissaoController::class, 'index'])->name('comissoes.index');
    Route::post('comissoes/salvar-filial', [App\Http\Controllers\ComissaoController::class, 'salvarComissaoFilial'])->name('comissoes.salvar-filial');
    Route::post('comissoes/salvar-servico', [App\Http\Controllers\ComissaoController::class, 'salvarComissaoServico'])->name('comissoes.salvar-servico');
    Route::delete('comissoes/remover-servico/{id}', [App\Http\Controllers\ComissaoController::class, 'removerComissaoServico'])->name('comissoes.remover-servico');
    
    Route::resource('/admin/clientes', App\Http\Controllers\ClienteController::class); 
    Route::get('/admin/clientes/{cliente}/detalhes', [App\Http\Controllers\ClienteController::class, 'detalhes'])->name('clientes.detalhes');
    Route::resource('/admin/categorias', App\Http\Controllers\CategoriaController::class);  
    Route::resource('/admin/produtos', App\Http\Controllers\ProdutoController::class); 
    Route::prefix('produtos/{produto}')->name('produtos.')->group(function() {
        Route::get('filiais', [App\Http\Controllers\ProdutoFilialController::class, 'getFiliais'])->name('filiais');
        Route::post('filiais/{filial}/vincular', [App\Http\Controllers\ProdutoFilialController::class, 'vincular'])->name('filiais.vincular');
        Route::put('filiais/{filial}/atualizar', [App\Http\Controllers\ProdutoFilialController::class, 'atualizar'])->name('filiais.atualizar');
        Route::delete('filiais/{filial}/desvincular', [App\Http\Controllers\ProdutoFilialController::class, 'desvincular'])->name('filiais.desvincular');
        Route::patch('filiais/{filial}/toggle-status', [App\Http\Controllers\ProdutoFilialController::class, 'toggleStatus'])->name('filiais.toggle-status');
    });
    Route::resource('/admin/agendamentos', App\Http\Controllers\AgendamentoController::class); 
    Route::resource('/admin/configuracoes', App\Http\Controllers\ConfiguracaoController::class)->parameters(['configuracoes' => 'configuracao']); 
    Route::get('admin/agendamentos/barbeiros-filial/{filial}', [App\Http\Controllers\AgendamentoController::class, 'getBarbeirosPorFilial'])->name('admin.agendamentos.barbeiros-filial');
    Route::post('admin/agendamentos/{agendamento}/atualizar-barbeiro', [App\Http\Controllers\AgendamentoController::class, 'atualizarBarbeiro'])->name('admin.agendamentos.atualizar-barbeiro');
    // Financeiro
    Route::resource('/admin/categorias-financeiras', App\Http\Controllers\CategoriaFinanceiraController::class)->parameters(['categorias-financeiras' => 'categoriaFinanceira']); 
    Route::resource('/admin/formas-pagamento', App\Http\Controllers\FormaPagamentoController::class)->parameters(['formas-pagamento' => 'formaPagamento']); 
    Route::resource('/admin/financeiro', App\Http\Controllers\MovimentacaoFinanceiraController::class)->parameters(['financeiro' => 'movimentacao']); 
    Route::put('/admin/financeiro/{financeiro}/cancelar', [App\Http\Controllers\MovimentacaoFinanceiraController::class,'cancelar']); 
    Route::put('/admin/financeiro/{financeiro}/baixar', [App\Http\Controllers\MovimentacaoFinanceiraController::class, 'baixar']); 
    Route::get('/admin/financeiro/produtos-por-filial/{filial}', [App\Http\Controllers\MovimentacaoFinanceiraController::class, 'getProdutosByFilial'])->name('financeiro.produtos-por-filial');


    Route::post('/agendamentos/{id}/associar', [App\Http\Controllers\AgendamentoController::class, 'associarSlot']);
    Route::post('/agendamentos/gerar-lote', [App\Http\Controllers\AgendamentoController::class, 'gerarEmLote'])->name('agendamentos.gerar-lote');

    Route::post('/admin/agendamentos/{agendamento}/cancelar', [App\Http\Controllers\AgendamentoController::class, 'cancelarAtendimento'])->name('agendamentos.cancelar-atendimento');
    Route::post('/admin/agendamentos/{agendamento}/mudar-status', [App\Http\Controllers\AgendamentoController::class, 'mudarStatus'])->name('agendamentos.mudar-status');
    Route::post('/admin/agendamentos/{agendamento}/iniciar', [App\Http\Controllers\AgendamentoController::class, 'iniciarAtendimento'])->name('agendamentos.iniciar-atendimento');
    Route::post('/admin/agendamentos/{agendamento}/finalizar', [App\Http\Controllers\AgendamentoController::class, 'finalizarAtendimento'])->name('agendamentos.finalizar-atendimento');
    Route::get('/admin/agendamentos/barbeiros/{agendamento}', [App\Http\Controllers\AgendamentoController::class, 'buscarBarbeirosDisponiveis'])->name('agendamentos.buscar-barbeiros');
    Route::get('admin/agendamentos/servicos/{agendamento}', [App\Http\Controllers\AgendamentoController::class, 'getServicosPorAgendamento'])->name('admin.agendamentos.servicos');

    // Usuários
    Route::resource('/admin/users', App\Http\Controllers\UserController::class);
    Route::get('/admin/perfil', [App\Http\Controllers\UserController::class, 'perfilIndex'])->name('perfilindex');

    Route::get('/admin/relatorios',  [App\Http\Controllers\RelatorioController::class, 'index'])->name('relatorios.index');

    Route::prefix('relatorios')->name('relatorios.')->group(function() {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
        Route::post('/faturamento-mensal', [RelatorioController::class, 'faturamentoMensal'])->name('faturamento-mensal');
        Route::post('/comissoes-barbeiros', [RelatorioController::class, 'comissoesBarbeiros'])->name('comissoes-barbeiros');
        Route::post('/novos-clientes', [RelatorioController::class, 'novosClientes'])->name('novos-clientes');
        Route::post('/aniversariantes', [RelatorioController::class, 'aniversariantes'])->name('aniversariantes');
        Route::post('/taxa-ocupacao', [RelatorioController::class, 'taxaOcupacao'])->name('taxa-ocupacao');
        Route::post('/performance-barbeiros', [RelatorioController::class, 'performanceBarbeiros'])->name('performance-barbeiros');
        Route::post('/perfil-clientes', [RelatorioController::class, 'perfilClientes'])->name('perfil-clientes');
    });
});
