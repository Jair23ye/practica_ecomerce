@extends('layouts.app')
@section('title', 'Dashboard Cliente')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Bienvenido, {{ Auth::user()->nombre }} 👋
    </h1>

    <h2 class="text-xl font-semibold text-gray-700 mb-4">Productos disponibles</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($productos as $producto)
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold text-gray-800">{{ $producto->nombre }}</h3>
                <p class="text-gray-500 text-sm mt-1">{{ $producto->descripcion }}</p>
                <p class="text-blue-600 font-bold mt-2">${{ number_format($producto->precio, 2) }}</p>
                <p class="text-gray-500 text-sm">Existencia: {{ $producto->existencia }}</p>
                <div class="flex flex-wrap gap-1 mt-2">
                    @foreach($producto->categorias as $categoria)
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">
                            {{ $categoria->nombre }}
                        </span>
                    @endforeach
                </div>
                <a href="{{ route('ventas.create') }}"
                   class="mt-4 block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                    Comprar
                </a>
            </div>
        @empty
            <p class="text-gray-500 col-span-3">No hay productos disponibles.</p>
        @endforelse
    </div>
</div>
@endsection