<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;

class ProdutosController extends Controller
{   
    public function index(Request $request)
    {
        $produtos = Produto::all();
        $query = Produto::query();

        if ($request->filled('nome')) 
        {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
    
        if ($request->filled('descricao')) 
        {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        }
    
        $produtos = $query->get();
    
        return view('produtos.index', compact('produtos'));
    }

    public function gerarPdf()
    {
        $produtos = Produto::all();
        $pdf = Pdf::loadView('produtos.pdf', compact('produtos'));

        return $pdf->stream('lista-produtos.pdf');
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required|numeric',
        ]);

        Produto::create($request->all());
        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso.');
    }

    public function edit(string $id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required|numeric',
        ]);

        $produto = Produto::findOrFail($id);
        $produto->update($request->all());

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso.');
    }

    public function test_pesquisa_por_descricao_funciona()
    {
        Produto::factory()->create(['descricao' => '180']);
        Produto::factory()->create(['descricao' => 'teste']);

        $response = $this->get('/produtos?descricao=180');

        $response->assertStatus(200);
        $response->assertSee('180');
        $response->assertDontSee('teste');
    }
}
