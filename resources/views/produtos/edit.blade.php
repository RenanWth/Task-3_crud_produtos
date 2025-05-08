@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

        <!-- Título -->
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">Editar Produto</h1>

        <!-- Exibição de erros -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-md border border-red-300">
                <ul>
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulário de Edição -->
        <form action="{{ route('produtos.update', $produto) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                <input type="text" name="nome" value="{{ old('nome', $produto->nome) }}" id="nome"
                    class="mt-1 block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            </div>

            <div class="mb-4">
                <label for="descricao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                <input type="text" name="descricao" value="{{ old('descricao', $produto->descricao) }}" id="descricao"
                    class="mt-1 block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            </div>

            <div class="mb-4">
                <label for="preco" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preço</label>
                <input type="text" name="preco" value="{{ old('preco', $produto->preco) }}" id="preco"
                    class="mt-1 block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            </div>

            <div class="flex items-center space-x-4 mt-6">
                <!-- Botão de Atualizar -->
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Atualizar
                </button>

                <!-- Botão de Cancelar -->
                <a href="{{ route('produtos.index') }}"
                class="inline-flex items-center px-6 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
