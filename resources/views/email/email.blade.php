<!--resources/views/emails/novo_item.blade.php-->

<!DOCTYPE html>
<html>
<head>
    <title>Item Criado</title>
</head>
<body>
    <h1>Um novo item foi criado</h1>
    <p>Nome do item: {{ $item->nome }}</p>
    <p>Descrição: {{ $item->descricao }}</p>
    <p>Preço: {{ $item->preco }}</p>
    <a href="{{ route('email.simulado', $item->id) }}">
    <button>Simular Envio de Email</button>
</a>
</body>
</html>
