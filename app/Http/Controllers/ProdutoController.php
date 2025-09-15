<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::with('categoria')
        ->select('produtos.*')
        ->selectRaw('(
            (
                SELECT COALESCE(SUM(ap.quantidade), 0)
                FROM agendamento_produto ap
                JOIN agendamentos a ON ap.agendamento_id = a.id
                WHERE a.status IN (?, ?)
                AND ap.produto_id = produtos.id
            ) +
            (
                SELECT COALESCE(SUM(mp.quantidade), 0)
                FROM movimentacao_produto mp
                JOIN movimentacoes_financeiras mf ON mp.movimentacao_financeira_id = mf.id
                WHERE mf.situacao = ?
                AND mp.produto_id = produtos.id
            )
        ) AS comprometido', ['agendado', 'em_andamento', 'em_aberto']);

    // Filtros backend (aplicar antes de get/paginate)
    if ($request->filled('busca')) {
        $search = $request->busca;
        $query->where(function($q) use ($search) {
            $q->where('nome', 'like', "%{$search}%")
            ->orWhere('descricao', 'like', "%{$search}%");
        });
    }

    if ($request->filled('status')) {
        $query->where('ativo', $request->status);
    }

    if ($request->filled('tipo')) {
        $query->where('tipo', $request->tipo);
    }

    if ($request->filled('categoria_id')) {
        $query->where('categoria_id', $request->categoria_id);
    }

    $perPage = $request->get('per_page', 15);
    $produtos = $query->orderBy('nome')->paginate($perPage);

    // Estatísticas
    $stats = [
        'total' => Produto::count(),
        'ativos' => Produto::where('ativo', true)->count(),
        'produtos' => Produto::where('tipo', 'produto')->count(),
        'servicos' => Produto::where('tipo', 'servico')->count(),
    ];

    $categorias = Categoria::where('ativo', true)->orderBy('nome')->get();

    return view('admin.produtos.index', compact('produtos', 'stats', 'categorias'));

    }

    public function store(Request $request)
    {
        try{
        
            $request->validate([
                'nome' => 'required|string|max:255',
                'preco' => 'required|numeric|min:0',
                'categoria_id' => 'required|exists:categorias,id',
                'tipo' => 'required|in:produto,servico',
                'estoque' => 'nullable|integer|min:0',
                'descricao' => 'nullable|string',
                'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $data = $request->all();
            $data['ativo'] = $request->has('ativo');
            $data['site'] = $request->has('site');
    
            if ($request->hasFile('imagem')) {
                $image = $request->file('imagem');
                $imageData = file_get_contents($image->getRealPath());
                $base64 = base64_encode($imageData);
                $mimeType = $image->getMimeType();
                $data['imagem'] = 'data:' . $mimeType . ';base64,' . $base64;
            }
    
            Produto::create($data);
    
            return redirect()->route('produtos.index')->with(['type' => 'success', 'message' => 'Produto/Serviço criado com sucesso!']);
        } catch( \Exception $e) {
            return redirect()->route('produtos.index')->with(['type' => 'error', 'message' => 'Erro ao criar produto/serviço: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Produto $produto)
    {
        try{
            
            $request->validate([
                'nome' => 'required|string|max:255',
                'preco' => 'required|numeric|min:0',
                'categoria_id' => 'required|exists:categorias,id',
                'tipo' => 'required|in:produto,servico',
                'estoque' => 'nullable|integer|min:0',
                'descricao' => 'nullable|string',
                'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->all();
            $data['ativo'] = $request->has('ativo');
            $data['site'] = $request->has('site');

            if ($request->hasFile('imagem')) {
                $image = $request->file('imagem');
                $imageData = file_get_contents($image->getRealPath());
                $base64 = base64_encode($imageData);
                $mimeType = $image->getMimeType();
                $data['imagem'] = 'data:' . $mimeType . ';base64,' . $base64;
            } else {
                unset($data['imagem']);
            }

            $produto->update($data);

            return redirect()->route('produtos.index')->with(['type' => 'success', 'message' => 'Produto/Serviço atualizado com sucesso!']);
        } catch( \Exception $e) {
            return redirect()->route('produtos.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar produto/serviço: ' . $e->getMessage()]);
        }
    }

    public function destroy(Produto $produto)
    {
        try{

            if(db::table("movimentacao_produto")->where('produto_id', $produto->id)->count() > 0 ){
                return redirect()->route('produtos.index')->with(['type' => 'error' , 'message'=> 'Não foi possível excluir o produto. Há movimentações financeiras associadas a ele.']);

            }

            if(db::table("agendamento_produto")->where('produto_id', $produto->id)->count() > 0 ){
                return redirect()->route('produtos.index')->with(['type' => 'error' , 'message'=> 'Não foi possível excluir o produto. Há agendamentos associados a ele.']);

            }

            $produto->delete();
            return redirect()->route('produtos.index')->with(['type' => 'success', 'message' => 'Produto/Serviço excluído com sucesso!']);
        } catch( \Exception $e) {
            return redirect()->route('produtos.index')->with(['type' => 'error', 'message' => 'Erro ao excluir produto/serviço: ' . $e->getMessage()]);
        }
    }
}
