@extends('layouts.app')
@section('title', 'Dashboard Gerente')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Panel Gerente</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-4xl font-bold text-green-600">{{ $totalProductos }}</p>
            <p class="text-gray-500 mt-1">Productos</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-4xl font-bold text-yellow-600">{{ $totalVentas }}</p>
            <p class="text-gray-500 mt-1">Ventas</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-4xl font-bold text-purple-600">{{ $totalCategorias }}</p>
            <p class="text-gray-500 mt-1">Categorías</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <a href="{{ route('productos.index') }}"
           class="bg-green-600 text-white px-6 py-4 rounded-xl text-center font-bold hover:bg-green-700 transition">
            Gestionar Productos
        </a>
        <a href="{{ route('categorias.index') }}"
           class="bg-purple-600 text-white px-6 py-4 rounded-xl text-center font-bold hover:bg-purple-700 transition">
            Gestionar Categorías
        </a>
        <a href="{{ route('ventas.index') }}"
           class="bg-yellow-600 text-white px-6 py-4 rounded-xl text-center font-bold hover:bg-yellow-700 transition">
            Gestionar Ventas
        </a>
    </div>

    <h2 class="text-xl font-bold text-gray-700 mb-4">Últimas Ventas</h2>
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Producto</th>
                    <th class="px-6 py-3 text-left">Cliente</th>
                    <th class="px-6 py-3 text-left">Fecha</th>
                    <th class="px-6 py-3 text-left">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($ventas as $venta)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $venta->producto->nombre }}</td>
                        <td class="px-6 py-4">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</td>
                        <td class="px-6 py-4">{{ $venta->fecha }}</td>
                        <td class="px-6 py-4 text-blue-600 font-bold">${{ number_format($venta->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay ventas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection