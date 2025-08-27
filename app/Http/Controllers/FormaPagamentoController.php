<?php

namespace App\Http\Controllers;

use App\Models\FormaPagamento;
use Illuminate\Http\Request;

class FormaPagamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = FormaPagamento::query();

        if ($request->filled('busca') && $request->busca !== null) {
            $query->where('nome', 'like', '%' . $request->busca . '%')
                  ->orWhere('descricao', 'like', '%' . $request->busca . '%');
        }

        if ($request->filled('status') && $request->status !== null) {
            $query->where('ativo', $request->status);
        }

        $formasPagamento = $query->orderBy('nome')->paginate($request->get('per_page', 10));

        $totalFormas = FormaPagamento::count();
        $formasAtivas = FormaPagamento::where('ativo', true)->count();
        $formasInativas  = FormaPagamento::where('ativo', false)->count();

        return view('admin.formas-pagamento.index', compact(
            'formasPagamento', 'totalFormas', 'formasAtivas', 'formasInativas'
        ));
    }

    public function store(Request $request)
    {

        try{
            $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string',
            ]);
    
            $data = $request->all();
            $data['ativo'] = $request->has('ativo');
    
            FormaPagamento::create($data);
            return redirect()->route('formas-pagamento.index')
                        ->with(['type' => 'success', 'message' => 'Forma de pagamento criada com sucesso!']);
        } catch (\Exception $e) {
            return redirect()->route('formas-pagamento.index')
                        ->with(['type' => 'error', 'message' => 'Erro ao criar forma de pagamento: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, FormaPagamento $formaPagamento)
    {
        try{

            $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string',
            ]);
    
            $data = $request->all();
            $data['ativo'] = $request->has('ativo');
    
            $formaPagamento->update($data);
            return redirect()->route('formas-pagamento.index')
                        ->with(['type' => 'success', 'message' => 'Forma de pagamento atualizada com sucesso!']);
        } catch (\Exception $e) {
            return redirect()->route('formas-pagamento.index')
                        ->with(['type' => 'error', 'message' => 'Erro ao atualizar forma de pagamento: ' . $e->getMessage()]);
        }
    }

    public function destroy(FormaPagamento $formaPagamento)
    {
        try{
            if ($formaPagamento->movimentacoes()->count() > 0) {
                return redirect()->route('formas-pagamento.index')
                            ->with(['type' => 'error', 'message' => 'Não é possível excluir esta forma de pagamento pois existem movimentações financeiras vinculadas a ela.']);
            }

        $formaPagamento->delete();
            return redirect()->route('formas-pagamento.index')
                        ->with(['type' => 'success', 'message' => 'Forma de pagamento excluída com sucesso!']);
        } catch (\Exception $e) {
            return redirect()->route('formas-pagamento.index')
                        ->with(['type' => 'error', 'message' => 'Erro ao excluir forma de pagamento: ' . $e->getMessage()]);
        }
    }
}
