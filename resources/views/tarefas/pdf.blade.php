<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Tarefas</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Lista de Tarefas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Observação</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tarefas as $tarefa)
                <tr>
                    <td>{{ $tarefa->id }}</td>
                    <td>{{ $tarefa->nome }}</td>
                    <td>{{ $tarefa->observacao }}</td>
                    <td>{{ ucfirst($tarefa->estado) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
