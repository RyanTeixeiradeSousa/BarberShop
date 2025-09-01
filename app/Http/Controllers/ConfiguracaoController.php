<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $configuracoes = Configuracao::all();
        return view('admin.configuracoes.index', compact('configuracoes'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'chave' => 'required|string|max:255|unique:configuracoes,chave',
                'valor' => 'required|string',
                'descricao' => 'nullable|string|max:500'
            ]);

            Configuracao::create($request->all());
            return redirect()->route('configuracoes.index')->with(['type' => 'success', 'message' => 'Configuração criada com sucesso!']);
        
        } catch( \Exception $e) {
            return redirect()->route('configuracoes.index')->with(['type' => 'error', 'message' => 'Erro ao salvar configuração: ' . $e->getMessage()]);
        }
        
    }

    public function update(Request $request, Configuracao $configuracao)
    {
        try{
            $request->validate([
                'chave' => 'required|string|max:255|unique:configuracoes,chave,' . $configuracao->id,
                'valor' => 'required|string',
                'descricao' => 'nullable|string'
            ]);
    
            $configuracao->update($request->all());
            return redirect()->route('configuracoes.index')->with(['type' => 'success', 'message' => 'Configuração atualizada com sucesso!']);
        } catch( \Exception $e) {
            dd($e->getMessage());
            return redirect()->route('configuracoes.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar configuração: ' . $e->getMessage()]);
        }   

        
    }

    public function destroy(Configuracao $configuracao)
    {
        try{
            $essenciais = ['duracao_servico_padrao'];
            
            if (in_array($configuracao->chave, $essenciais)) {
                return redirect()->route('configuracoes.index')
                    ->with('error', 'Esta configuração não pode ser excluída!');
            }
    
            $configuracao->delete();

            return redirect()->route('configuracoes.index')->with(['type' => 'success', 'message' => 'Configuração excluída com sucesso!']);
        } catch( \Exception $e) {
            return redirect()->route('configuracoes.index')->with(['type' => 'error', 'message' => 'Erro ao excluir configuração: ' . $e->getMessage()]);
        }        
    }
}
