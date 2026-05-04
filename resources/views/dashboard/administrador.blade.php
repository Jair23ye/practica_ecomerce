@extends('layouts.app')
@section('title', 'Dashboard Administrador')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Panel Administrador</h1>

    {{-- ── Tarjetas de totales ────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10">
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $totalUsuarios }}</p>
            <p class="text-gray-500 text-sm mt-1">Usuarios totales</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-indigo-600">{{ $totalVendedores }}</p>
            <p class="text-gray-500 text-sm mt-1">Vendedores</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-teal-600">{{ $totalCompradores }}</p>
            <p class="text-gray-500 text-sm mt-1">Compradores</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $totalProductos }}</p>
            <p class="text-gray-500 text-sm mt-1">Productos</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center">
            <p class="text-3xl font-bold text-yellow-600">{{ $totalVentas }}</p>
            <p class="text-gray-500 text-sm mt-1">Ventas</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        {{-- ── Producto más vendido ─────────────────────────────────── --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Producto más vendido</h2>
            @if($productoMasVendido && $productoMasVendido->ventas_count > 0)
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xl font-bold text-gray-800">{{ $productoMasVendido->nombre }}</p>
                        <p class="text-sm text-gray-500">${{ number_format($productoMasVendido->precio, 2) }}</p>
                    </div>
                    <span class="bg-green-100 text-green-700 text-2xl font-bold px-4 py-2 rounded-xl">
                        {{ $productoMasVendido->ventas_count }}
                        <span class="text-sm font-normal">ventas</span>
                    </span>
                </div>
            @else
                <p class="text-gray-400">Sin datos de ventas aún.</p>
            @endif
        </div>

        {{-- ── Comprador más frecuente (global) ────────────────────── --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Comprador más frecuente</h2>
            @if($compradorFrecuente)
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xl font-bold text-gray-800">
                            {{ $compradorFrecuente->nombre }} {{ $compradorFrecuente->apellidos }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $compradorFrecuente->correo }}</p>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-2xl font-bold px-4 py-2 rounded-xl">
                        {{ $compradorFrecuente->ventas_como_cliente_count }}
                        <span class="text-sm font-normal">compras</span>
                    </span>
                </div>
            @else
                <p class="text-gray-400">Sin datos de compradores aún.</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        {{-- ── Productos por categoría (withCount + belongsToMany) ─── --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Productos por categoría</h2>
            <div class="space-y-2">
                @forelse($productosPorCategoria as $cat)
                    <div class="flex items-center justify-between py-1">
                        <span class="text-sm text-gray-700">{{ $cat->nombre }}</span>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $cat->productos_count }} productos
                        </span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Sin categorías.</p>
                @endforelse
            </div>
        </div>

        {{-- ── Comprador más frecuente por categoría ───────────────── --}}
        {{-- Datos cargados con Categoria::with(['productos.ventas.cliente']) --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Comprador frecuente por categoría</h2>
            <div class="space-y-3">
                @forelse($compradorPorCategoria as $item)
                    <div class="flex items-center justify-between border-b pb-2 last:border-0">
                        <span class="text-sm font-medium text-gray-600">{{ $item['categoria'] }}</span>
                        @if($item['comprador'])
                            <span class="text-sm text-gray-800 font-semibold">
                                {{ $item['comprador']->nombre }} {{ $item['comprador']->apellidos }}
                            </span>
                        @else
                            <span class="text-xs text-gray-400 italic">Sin compras</span>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Sin datos.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── Accesos rápidos ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('usuarios.index') }}"
           class="bg-blue-600 text-white px-6 py-4 rounded-xl text-center font-bold hover:bg-blue-700 transition text-sm">
            Gestionar Usuarios
        </a>
        <a href="{{ route('productos.index') }}"
           class="bg-green-600 text-white px-6 py-4 rounded-xl text-center font-bold hover:bg-green-700 transition text-sm">
            Gestionar Productos
        </a>
        <a href="{{ route('categorias.index') }}"
           class="bg-purple-600 text-white px-6 py-4 rounded-xl text-center font-bold hover:bg-purple-700 transition text-sm">
            Gestionar Categorías
        </a>
        <a href="{{ route('ventas.index') }}"
           class="bg-yellow-600 text-white px-6 py-4 rounded-xl text-center font-bold hover:bg-yellow-700 transition text-sm">
            Gestionar Ventas
        </a>
    </div>

</div>
@endsection