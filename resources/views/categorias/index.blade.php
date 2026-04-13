@extends('layouts.app')
@section('title', 'Categorías')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Categorías</h1>
        @can('create', App\Models\Categoria::class)
            <a href="{{ route('categorias.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Nueva Categoría
            </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($categorias as $categoria)
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800">{{ $categoria->nombre }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ $categoria->descripcion }}</p>
                <p class="text-gray-500 text-sm mt-2">Productos: {{ $categoria->productos->count() }}</p>
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('categorias.show', $categoria) }}"
                       class="text-sm bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">Ver</a>
                    @can('update', $categoria)
                        <a href="{{ route('categorias.edit', $categoria) }}"
                           class="text-sm bg-yellow-100 px-3 py-1 rounded hover:bg-yellow-200">Editar</a>
                    @endcan
                    @can('delete', $categoria)
                        <form method="POST" action="{{ route('categorias.destroy', $categoria) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('¿Eliminar categoría?')"
                                class="text-sm bg-red-100 px-3 py-1 rounded hover:bg-red-200">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-3">No hay categorías registradas.</p>
        @endforelse
    </div>
</div>
@endsection