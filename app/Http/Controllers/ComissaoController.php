<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barbeiro;
use App\Models\BarbeiroComissao;
use App\Models\BarbeiroServicoComissao;
use App\Models\Produto;
use App\Models\Filial;

class ComissaoController extends Controller
{
    public function index($barbeiroId, $filialId)
    {
        
        try{

            $barbeiro = Barbeiro::findOrFail($barbeiroId);
            $comissaoFilial = BarbeiroComissao::where('barbeiro_id', $barbeiroId)
                                             ->where('filial_id', $filialId)
                                             ->first();
            $comissoesServicos = BarbeiroServicoComissao::where('barbeiro_id', $barbeiroId)
                                                       ->where('filial_id', $filialId)
                                                       ->with('produto')
                                                       ->get();
            $filial = Filial::find($filialId);
            $produtos = Produto::where('ativo', true)->where('tipo', 'servico')->get();
                
            return view('admin.comissoes.index', compact('filial','barbeiro', 'filialId', 'comissaoFilial', 'comissoesServicos', 'produtos'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function salvarComissaoFilial(Request $request)
    {
        $request->validate([
            'barbeiro_id' => 'required|exists:barbeiros,id',
            'filial_id' => 'required|exists:filiais,id',
            'tipo_comissao_filial' => 'required|in:percentual,valor_fixo',
            'valor_comissao_filial' => 'required|numeric|min:0'
        ]);

        BarbeiroComissao::updateOrCreate(
            [
                'barbeiro_id' => $request->barbeiro_id,
                'filial_id' => $request->filial_id
            ],
            [
                'tipo_comissao_filial' => $request->tipo_comissao_filial,
                'valor_comissao_filial' => $request->valor_comissao_filial
            ]
        );

        return response()->json(['success' => true, 'message' => 'Comissão da filial salva com sucesso!']);
    }

    public function salvarComissaoServico(Request $request)
    {
        $request->validate([
            'barbeiro_id' => 'required|exists:barbeiros,id',
            'filial_id' => 'required|exists:filiais,id',
            'produto_id' => 'required|exists:produtos,id',
            'tipo_comissao' => 'required|in:percentual,valor_fixo',
            'valor_comissao' => 'required|numeric|min:0'
        ]);

        BarbeiroServicoComissao::updateOrCreate(
            [
                'barbeiro_id' => $request->barbeiro_id,
                'filial_id' => $request->filial_id,
                'produto_id' => $request->produto_id
            ],
            [
                'tipo_comissao' => $request->tipo_comissao,
                'valor_comissao' => $request->valor_comissao
            ]
        );

        return response()->json(['success' => true, 'message' => 'Comissão do serviço salva com sucesso!']);
    }

    public function removerComissaoServico($id)
    {
        $comissao = BarbeiroServicoComissao::findOrFail($id);
        $comissao->delete();

        return response()->json(['success' => true, 'message' => 'Comissão do serviço removida com sucesso!']);
    }
}
