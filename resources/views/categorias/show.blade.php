@extends('layouts.app')
@section('title', 'Detalle Categoría')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $categoria->nombre }}</h1>
        <p class="text-gray-500 mb-6">{{ $categoria->descripcion }}</p>

        <h2 class="text-xl font-semibold text-gray-700 mb-3">Productos en esta categoría:</h2>
        <ul class="space-y-2">
            @forelse($categoria->productos as $producto)
                <li class="flex justify-between items-center bg-gray-50 px-4 py-2 rounded-lg">
                    <span>{{ $producto->nombre }}</span>
                    <span class="text-blue-600 font-bold">${{ number_format($producto->precio, 2) }}</span>
                </li>
            @empty
                <p class="text-gray-500">No hay productos en esta categoría.</p>
            @endforelse
        </ul>

        <div class="flex gap-3 mt-6">
            @can('update', $categoria)
                <a href="{{ route('categorias.edit', $categoria) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                    Editar
                </a>
            @endcan
            <a href="{{ route('categorias.index') }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection