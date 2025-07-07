<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;

class EmailController extends Controller
{
    public function compose()
    {
        return view('email.email');
    }

    public function simularEnvio($id)
    {
        $item = Tarefa::findOrFail($id);

        // Renderiza o corpo do e-mail (só para simular)
        $htmlEmail = view('email.email', compact('item'))->render();

        // Exibe o conteúdo renderizado (opcional, para visualização)
        // return $htmlEmail;

        // Simula envio e retorna true
        return response()->json([
            'status' => true,
            'mensagem' => 'Email simulado com sucesso!',
            'conteudo' => $htmlEmail // Opcional: retorna o corpo renderizado
        ]);
    }

}
