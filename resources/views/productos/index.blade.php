@extends('layouts.app')
@section('title', 'Productos')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Productos</h1>
        @can('create', App\Models\Producto::class)
            <a href="{{ route('productos.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Nuevo Producto
            </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($productos as $producto)
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800">{{ $producto->nombre }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ $producto->descripcion }}</p>
                <p class="text-blue-600 font-bold mt-2">${{ number_format($producto->precio, 2) }}</p>
                <p class="text-gray-500 text-sm">Existencia: {{ $producto->existencia }}</p>
                <p class="text-gray-500 text-sm">Vendedor: {{ $producto->usuario->nombre }} {{ $producto->usuario->apellidos }}</p>
                <div class="flex flex-wrap gap-1 mt-2">
                    @foreach($producto->categorias as $categoria)
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">
                            {{ $categoria->nombre }}
                        </span>
                    @endforeach
                </div>
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('productos.show', $producto) }}"
                       class="text-sm bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">Ver</a>
                    @can('update', $producto)
                        <a href="{{ route('productos.edit', $producto) }}"
                           class="text-sm bg-yellow-100 px-3 py-1 rounded hover:bg-yellow-200">Editar</a>
                    @endcan
                    @can('delete', $producto)
                        <form method="POST" action="{{ route('productos.destroy', $producto) }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('¿Eliminar producto?')"
                                class="text-sm bg-red-100 px-3 py-1 rounded hover:bg-red-200">
                                Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-3">No hay productos registrados.</p>
        @endforelse
    </div>
</div>
@endsection