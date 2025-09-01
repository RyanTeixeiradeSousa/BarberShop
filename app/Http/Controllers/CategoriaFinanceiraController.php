<?php

namespace App\Http\Controllers;

use App\Models\CategoriaFinanceira;
use Illuminate\Http\Request;

class CategoriaFinanceiraController extends Controller
{
    public function index(Request $request)
    {
        $query = CategoriaFinanceira::query();

        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%')
                  ->orWhere('descricao', 'like', '%' . $request->busca . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('ativo', $request->status);
        }

        $categorias = $query->orderBy('nome')->paginate($request->get('per_page', 10));

        $totalCategorias = CategoriaFinanceira::count();
        $categoriasAtivas = CategoriaFinanceira::where('ativo', true)->count();
        $categoriasInativas = CategoriaFinanceira::where('ativo', false)->count();
        $categoriasEntrada = CategoriaFinanceira::whereIn('tipo', ['entrada', 'ambos'])->count();
        $categoriasSaida = CategoriaFinanceira::whereIn('tipo', ['saida', 'ambos'])->count();

        return view('admin.categorias-financeiras.index', compact(
            'categorias', 'totalCategorias', 'categoriasAtivas', 
            'categoriasEntrada', 'categoriasSaida','categoriasInativas'
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
    
            CategoriaFinanceira::create($data);

            return redirect()->route('categorias-financeiras.index')->with(['type' => 'success', 'message' => 'Categoria financeira criada com sucesso!']);
        } catch (\Exception $e) {
            return redirect()->route('categorias-financeiras.index')->with(['type' => 'error', 'message' => 'Erro ao criar categoria financeira: ' . $e->getMessage()]);
        }

        
    }

    public function update(Request $request, CategoriaFinanceira $categoriaFinanceira)
    {
        try{
            $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string',
                'tipo' => 'required|in:entrada,saida,ambos',
            ]);

            $data = $request->all();
            $data['ativo'] = $request->has('ativo');
    
            $categoriaFinanceira->update($data);
            return redirect()->route('categorias-financeiras.index')->with(['type' => 'success', 'message' => 'Categoria financeira atualizada com sucesso!']);
        } catch (\Exception $e) {
            return redirect()->route('categorias-financeiras.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar categoria financeira: ' . $e->getMessage()]);
        }

       
    }

    public function destroy(CategoriaFinanceira $categoriaFinanceira)
    {
        try{
            if ($categoriaFinanceira->movimentacoes()->count() > 0) {
                return redirect()->route('categorias-financeiras.index')
                                ->with('error', 'Não é possível excluir uma categoria que possui movimentações associadas.');
            }
    
            $categoriaFinanceira->delete();
            return redirect()->route('categorias-financeiras.index')->with(['type' => 'success', 'message' => 'Categoria financeira excluída com sucesso!']);
        } catch (\Exception $e) {
            return redirect()->route('categorias-financeiras.index')->with(['type' => 'error', 'message' => 'Erro ao excluir categoria financeira: ' . $e->getMessage()]);
        }   

    
    }
}
