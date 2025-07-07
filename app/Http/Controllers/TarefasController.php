<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;

class TarefasController extends Controller
{   
    public function index(Request $request)
    {
        $query = Tarefa::query();

        if ($request->filled('nome')) 
        {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        if ($request->filled('observacao')) 
        {
            $query->where('observacao', 'like', '%' . $request->observacao . '%');
        }
        if ($request->filled('estado'))
        {
            $query->where('estado', $request->estado);
        }
        $tarefas = $query->get();
        return view('tarefas.index', compact('tarefas'));
    }

    public function gerarPdf()
    {
        $tarefas = Tarefa::all();
        $pdf = Pdf::loadView('tarefas.pdf', compact('tarefas'));
        return $pdf->stream('lista-tarefas.pdf');
    }

    public function create()
    {
        return view('tarefas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'estado' => 'required|in:pendente,em andamento,concluida',
        ]);
        Tarefa::create($request->all());
        return redirect()->route('tarefas.index')->with('success', 'Tarefa criada com sucesso.');
    }

    public function edit(string $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        return view('tarefas.edit', compact('tarefa'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required',
            'estado' => 'required|in:pendente,em andamento,concluida',
        ]);
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->update($request->all());
        return redirect()->route('tarefas.index')->with('success', 'Tarefa atualizada com sucesso.');
    }

    public function destroy(string $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();
        return redirect()->route('tarefas.index')->with('success', 'Tarefa excluída com sucesso.');
    }
}
