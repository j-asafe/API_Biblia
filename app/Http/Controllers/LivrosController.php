<?php

namespace App\Http\Controllers;

use App\Models\Livros;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LivrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buscando todas as Produtos
        $registros = Livros::all();

        // Contando o número de registros
        $contador = $registros->count();

        // Verificando se há registros
        if ($contador > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Livros encontrados com sucesso!',
                'data' => $registros,
                'total' => $contador
            ], 200); // Retorna HTTP 200 (OK) com os dados e a contagem
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum livro encontrado.',
            ], 404); // Retorna HTTP 404 (Not Found) se não houver registros
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'autor' => 'required',
            'destinatario' => 'required',
            'num_capitulos' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400); // Retorna HTTP 400 (Bad Request) se houver erro de validação
        }

        // Criando um produto no banco de dados
        $registros = Livros::create($request->all());

        if ($registros) {
            return response()->json([
                'success' => true,
                'message' => 'Livro cadastrado com sucesso!',
                'data' => $registros
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar um livro'
            ], 500); // Retorna HTTP 500 (Internal Server Error) se o cadastro falhar
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscando um produto pelo ID
        $registros = Livros::find($id);

        // Verificando se o produto foi encontrada
        if ($registros) {
            return response()->json([
                'success' => true,
                'message' => 'livro localizado com sucesso!',
                'data' => $registros
            ], 200); // Retorna HTTP 200 (OK) com os dados do produto
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Livro não localizado.',
            ], 404); // Retorna HTTP 404 (Not Found) se o produto não for encontrada
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'autor' => 'required',
            'destinatario' => 'required',
            'num_capitulos' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400); // Retorna HTTP 400 se houver erro de validação
        }

        // Encontrando um produto no banco
        $registrosBanco = Livros::find($id);

        if (!$registrosBanco) {
            return response()->json([
                'success' => false,
                'message' => 'Livro não encontrado'
            ], 404);
        }

        // Atualizando os dados
        $registrosBanco->nome = $request->nome;
        $registrosBanco->autor = $request->autor;
        $registrosBanco->destinatario = $request->destinatario;
         $registrosBanco->num_capitulos = $request->num_capitulos;

        // Salvando as alterações
        if ($registrosBanco->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Livro atualizado com sucesso!',
                'data' => $registrosBanco
            ], 200); // Retorna HTTP 200 se a atualização for bem-sucedida
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o livros'
            ], 500); // Retorna HTTP 500 se houver erro ao salvar
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrando um produto no banco
        $registros = Livros::find($id);

        if (!$registros) {
            return response()->json([
                'success' => false,
                'message' => 'Livro não encontrado'
            ], 404); // Retorna HTTP 404 se o produto não for encontrado
        }
     // Deletando um produto
    if ($registros->delete()){
        return response()->json([
            'success' => true,
            'message' => 'Livro deletado com sucesso'
        ],200); // Retorna HTTP 200 se a exclusão for bem-sucedida
    }

    return response()->json([
        'success' => false,
        'message' => 'Erro ao deletar um livro'
    ], 500); // Retorna HTTP 500 se houver erro na exclusão
    }
}