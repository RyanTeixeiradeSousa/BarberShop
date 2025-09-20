<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Filial;
use Illuminate\Http\Request;

class ProdutoFilialController extends Controller
{
    public function getFiliais(Produto $produto)
    {
        $filiaisVinculadas = $produto->filiais()->get();
        $todasFiliais = Filial::where('ativo', true)->get();
        $idsVinculadas = $filiaisVinculadas->pluck('id')->toArray();
        
        $vinculadas = $filiaisVinculadas->map(function ($filial) {
            return [
                'filial' => [
                    'id' => $filial->id,
                    'nome' => $filial->nome,
                    'endereco' => $filial->endereco ?? 'Endereço não informado'
                ],
                'estoque' => $filial->pivot->estoque_filial,
                'preco_filial' => $filial->pivot->preco_filial,
                'ativo' => $filial->pivot->ativo,
            ];
        });

        $disponiveis = $todasFiliais->filter(function ($filial) use ($idsVinculadas) {
            return !in_array($filial->id, $idsVinculadas);
        })->map(function ($filial) {
            return [
                'id' => $filial->id,
                'nome' => $filial->nome,
                'endereco' => $filial->endereco ?? 'Endereço não informado'
            ];
        })->values();

        return response()->json([
            'produto' => $produto,
            'vinculadas' => $vinculadas,
            'disponiveis' => $disponiveis
        ]);
    }

    public function vincular(Request $request, Produto $produto, Filial $filial)
    {
        try{
            $request->validate([
                'estoque_filial' => 'required_if:tipo,produto|integer|min:0',
                'preco_filial' => 'nullable|numeric|min:0',
                'ativo' => 'boolean'
            ]);
            
            $data = [
                'estoque_filial' => $produto->tipo == 'produto' ? ($request->estoque_filial) ?? 0 : 0,
                'preco_filial' => $request->preco_filial ?? null,
                'ativo' => $request->boolean('ativo', true)
            ];
            
            $produto->filiais()->syncWithoutDetaching([$filial->id => $data]);
    
            return response()->json([
                'success' => true,
                'message' => 'Produto vinculado à filial com sucesso!'
            ]);
        } catch(\Exception $e){
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao vincular produto à filial: ' . $e->getMessage()
            ], 500);
        }

    }

    public function atualizar(Request $request, Produto $produto, Filial $filial)
    {
        $request->validate([
            'estoque_filial' => 'required_if:tipo,produto|integer|min:0',
            'preco_filial' => 'nullable|numeric|min:0',
            'ativo' => 'boolean'
        ]);
        
        $data = [
            'estoque_filial' => $produto->tipo === 'produto' ? $request->estoque : 0,
            'preco_filial' => $request->preco_filial,
            'ativo' => $request->boolean('ativo', true)
        ];

        $produto->filiais()->updateExistingPivot($filial->id, $data);

        return response()->json([
            'success' => true,
            'message' => 'Vinculação atualizada com sucesso!'
        ]);
    }

    public function desvincular(Produto $produto, Filial $filial)
    {
        $produto->filiais()->detach($filial->id);

        return response()->json([
            'success' => true,
            'message' => 'Produto desvinculado da filial com sucesso!'
        ]);
    }

    public function toggleStatus(Produto $produto, Filial $filial)
    {
        $pivot = $produto->filiais()->where('filial_id', $filial->id)->first();
        
        if ($pivot) {
            $novoStatus = !$pivot->pivot->ativo;
            $produto->filiais()->updateExistingPivot($filial->id, ['ativo' => $novoStatus]);
            
            return response()->json([
                'success' => true,
                'ativo' => $novoStatus,
                'message' => $novoStatus ? 'Produto ativado na filial!' : 'Produto desativado na filial!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produto não está vinculado a esta filial!'
        ], 404);
    }
}
