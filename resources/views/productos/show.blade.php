@extends('layouts.app')
@section('title', 'Detalle Producto')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow p-8">

        {{-- Galería de fotos (disco público) --}}
        @if($producto->fotos && count($producto->fotos) > 0)
            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Fotos del producto</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($producto->fotos as $foto)
                        <img src="{{ Storage::disk('public')->url($foto) }}"
                             alt="{{ $producto->nombre }}"
                             class="w-full h-40 object-cover rounded-xl border border-gray-200">
                    @endforeach
                </div>
            </div>
        @endif

        <h1 class="text-3xl font-bold text-gray-800 mb-1">{{ $producto->nombre }}</h1>
        <p class="text-gray-500 mb-4">{{ $producto->descripcion }}</p>

        <div class="flex items-center gap-6 mb-4">
            <span class="text-2xl font-bold text-blue-600">${{ number_format($producto->precio, 2) }}</span>
            <span class="text-sm text-gray-500">Existencia: <strong>{{ $producto->existencia }}</strong></span>
        </div>

        <p class="text-gray-600 text-sm mb-4">
            Vendedor:
            <span class="font-semibold">{{ $producto->usuario->nombre }} {{ $producto->usuario->apellidos }}</span>
        </p>

        <div class="mb-4">
            <p class="font-semibold text-gray-700 mb-2 text-sm">Categorías:</p>
            <div class="flex flex-wrap gap-2">
                @forelse($producto->categorias as $categoria)
                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                        {{ $categoria->nombre }}
                    </span>
                @empty
                    <span class="text-gray-400 text-sm">Sin categorías</span>
                @endforelse
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg px-4 py-3 text-sm text-gray-600 mb-6">
            Ventas registradas: <strong>{{ $producto->ventas->count() }}</strong>
        </div>

        <div class="flex gap-3">
            @can('update', $producto)
                <a href="{{ route('productos.edit', $producto) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition text-sm">
                    Editar
                </a>
            @endcan
            @can('delete', $producto)
                <form method="POST" action="{{ route('productos.destroy', $producto) }}">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar este producto?')"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                        Eliminar
                    </button>
                </form>
            @endcan
            <a href="{{ route('productos.index') }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection