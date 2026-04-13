@extends('layouts.app')
@section('title', 'Detalle Producto')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $producto->nombre }}</h1>
        <p class="text-gray-500 mb-4">{{ $producto->descripcion }}</p>
        <p class="text-blue-600 font-bold text-xl">${{ number_format($producto->precio, 2) }}</p>
        <p class="text-gray-600 mt-2">Existencia: {{ $producto->existencia }}</p>
        <p class="text-gray-600">Vendedor: {{ $producto->usuario->nombre }} {{ $producto->usuario->apellidos }}</p>

        <div class="mt-4">
            <p class="font-semibold text-gray-700 mb-2">Categorías:</p>
            <div class="flex flex-wrap gap-2">
                @foreach($producto->categorias as $categoria)
                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                        {{ $categoria->nombre }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="mt-6">
            <p class="font-semibold text-gray-700 mb-2">Ventas registradas: {{ $producto->ventas->count() }}</p>
        </div>

        <div class="flex gap-3 mt-6">
            @can('update', $producto)
                <a href="{{ route('productos.edit', $producto) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                    Editar
                </a>
            @endcan
            <a href="{{ route('productos.index') }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection