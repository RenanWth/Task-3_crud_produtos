@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Lista de Tarefas</h1>
            <div class="flex space-x-4">
                <a href="{{ route('tarefas.create') }}"
                   class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Nova Tarefa
                </a>
                <a href="{{ route('tarefas.pdf') }}"
                   class="inline-flex items-center px-6 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                    Baixar PDF
                </a>
            </div>
        </div>
        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-700 p-4 rounded-md border border-green-300">
                {{ session('success') }}
            </div>
        @endif
        <form method="GET" action="{{ route('tarefas.index') }}" class="mb-6">
            <div class="flex flex-wrap gap-4 items-end">
                <div>
                    <label for="nome" class="block text-sm font-bold text-gray-800 dark:text-gray-100">Nome</label>
                    <input type="text" name="nome" id="nome" value="{{ request('nome') }}"
                           class="mt-1 block w-full border-blue-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="observacao" class="block text-sm font-bold text-gray-800 dark:text-gray-100">Observação</label>
                    <input type="text" name="observacao" id="observacao" value="{{ request('observacao') }}"
                           class="mt-1 block w-full border-blue-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="estado" class="block text-sm font-bold text-gray-800 dark:text-gray-100">Estado</label>
                    <select name="estado" id="estado" class="mt-1 block w-full border-blue-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Todos</option>
                        <option value="ativa" {{ request('estado') == 'ativa' ? 'selected' : '' }}>Ativa</option>
                        <option value="em andamento" {{ request('estado') == 'em andamento' ? 'selected' : '' }}>Em andamento</option>
                        <option value="concluida" {{ request('estado') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                    </select>
                </div>
                <div>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-sm font-semibold rounded-lg shadow-md focus:outline-none focus:ring-4 focus:ring-red-400 focus:ring-offset-2 transition duration-150 ease-in-out mt-6">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-sm text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left font-medium text-sm text-gray-600 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left font-medium text-sm text-gray-600 uppercase tracking-wider">Observação</th>
                        <th class="px-6 py-3 text-left font-medium text-sm text-gray-600 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left font-medium text-sm text-gray-600 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-sm text-gray-700">
                    @foreach ($tarefas as $tarefa)
                        <tr class="border-t border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $tarefa->id }}</td>
                            <td class="px-6 py-4">{{ $tarefa->nome }}</td>
                            <td class="px-6 py-4">{{ $tarefa->observacao }}</td>
                            <td class="px-6 py-4">{{ ucfirst($tarefa->estado) }}</td>
                            <td class="px-6 py-4 flex items-center space-x-3">
                                <a href="{{ route('tarefas.edit', $tarefa) }}" class="text-blue-500 hover:text-blue-700 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4h4v4M16 4l-8 8m8-8l-8 8" />
                                    </svg>
                                    Editar
                                </a>
                                <form action="{{ route('tarefas.destroy', $tarefa) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
