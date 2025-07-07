<!--resources/views/email/email.blade.php-->

<!DOCTYPE html>
<html>
<head>
    <title>Tarefa Criada</title>
</head>
<body>
    <h1>Uma nova tarefa foi criada</h1>
    <p>Nome da tarefa: {{ $item->nome }}</p>
    <p>Observação: {{ $item->observacao }}</p>
    <p>Estado: {{ ucfirst($item->estado) }}</p>
    <a href="{{ route('email.simulado', $item->id) }}">
    <button>Simular Envio de Email</button>
</a>
</body>
</html>
