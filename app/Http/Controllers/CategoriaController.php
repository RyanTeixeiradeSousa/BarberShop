<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Exception;
class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        // Filtro de busca
        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%')
                  ->orWhere('descricao', 'like', '%' . $request->busca . '%');
        }

        // Paginação
        $perPage = $request->get('per_page', 10);
        $categorias = $query->orderBy('nome')->paginate($perPage);

        // Estatísticas
        $totalCategorias = Categoria::count();

        return view('admin.categorias.index', compact('categorias', 'totalCategorias'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'nome' => 'required|string|max:255',
                    'descricao' => 'nullable|string|max:1000',
                ],
                [
                    'nome.required'  => 'O campo nome é obrigatório.',
                    'nome.string'    => 'O campo nome deve ser um texto válido.',
                    'nome.max'       => 'O campo nome não pode ter mais de 255 caracteres.',

                    'descricao.string' => 'O campo descrição deve ser um texto válido.',
                    'descricao.max'    => 'O campo descrição não pode ter mais de 1000 caracteres.',
                ]
            );

            if ($validator->fails()) {
                // Para uma aplicação web
                return redirect()->route('categorias.index')->with(['type' => 'error' , 'message'=> 'Campos inválidos para cadastro de categoria: ' . $validator->errors()->first(), 'errors' => $validator->errors()]);
        
            }
    
            Categoria::create($request->all());
    
            return redirect()->route('categorias.index')->with(['type' => 'success', 'message' => 'Categoria criada com sucesso!']);

        } catch (\Exception $e) {
            return redirect()->route('categorias.index')->with(['type' => 'error', 'message' => 'Erro ao criar categoria: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Categoria $categoria)
    {
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'nome' => 'required|string|max:255',
                    'descricao' => 'nullable|string|max:1000',
                ],
                [
                    'nome.required'  => 'O campo nome é obrigatório.',
                    'nome.string'    => 'O campo nome deve ser um texto válido.',
                    'nome.max'       => 'O campo nome não pode ter mais de 255 caracteres.',

                    'descricao.string' => 'O campo descrição deve ser um texto válido.',
                    'descricao.max'    => 'O campo descrição não pode ter mais de 1000 caracteres.',
                ]
            );

            if ($validator->fails()) {
                // Para uma aplicação web
                return redirect()->route('categorias.index')->with(['type' => 'error' , 'message'=> 'Campos inválidos para cadastro de categoria: ' . $validator->errors()->first(), 'errors' => $validator->errors()]);
        
            }

            $categoria->update($request->all());

            return redirect()->route('categorias.index')->with(['type' => 'success', 'message' => 'Categoria atualizada com sucesso!']);

        } catch (\Exception $e) {
            return redirect()->route('categorias.index')->with(['type' => 'error', 'message' => 'Erro ao atualizar categoria: ' . $e->getMessage()]);
        }
    }

    public function destroy(Categoria $categoria)
    {
         try{
        // Verificar se a categoria tem produtos associados
            if ($categoria->produtos()->count() > 0) {
                return redirect()->route('categorias.index')->with('error', 'Não é possível excluir uma categoria que possui produtos associados.');
            }

            $categoria->delete();

            return redirect()->route('categorias.index')->with(['type' => 'success', 'message' => 'Categoria excluída com sucesso!']);

        } catch (\Exception $e) {
            return redirect()->route('categorias.index')->with(['type' => 'error', 'message' => 'Erro ao excluir categoria: ' . $e->getMessage()]);
        }
    }
}
