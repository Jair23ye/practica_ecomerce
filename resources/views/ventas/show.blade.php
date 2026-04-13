@extends('layouts.app')
@section('title', 'Detalle Venta')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Detalle de Venta #{{ $venta->id }}</h1>

        <div class="space-y-3 text-sm text-gray-700">
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold">Producto:</span>
                <span>{{ $venta->producto->nombre }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold">Cliente:</span>
                <span>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold">Vendedor:</span>
                <span>{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold">Fecha:</span>
                <span>{{ $venta->fecha }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Total:</span>
                <span class="text-blue-600 font-bold text-lg">${{ number_format($venta->total, 2) }}</span>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            @can('update', $venta)
                <a href="{{ route('ventas.edit', $venta) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                    Editar
                </a>
            @endcan
            <a href="{{ route('ventas.index') }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection