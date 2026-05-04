@extends('layouts.app')
@section('title', 'Detalle Venta')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow p-8">

        <div class="flex items-start justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Venta #{{ $venta->id }}</h1>
            @if($venta->validada)
                <span class="bg-green-100 text-green-700 text-sm font-bold px-4 py-1.5 rounded-full">
                    ✓ Validada
                </span>
            @else
                <span class="bg-yellow-100 text-yellow-700 text-sm font-bold px-4 py-1.5 rounded-full">
                    Pendiente
                </span>
            @endif
        </div>

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

        {{-- Ticket (disco privado — solo dueño o gerente) --}}
        @can('verTicket', $venta)
            <div class="mt-6 border-t pt-5">
                <p class="text-sm font-semibold text-gray-700 mb-2">Ticket / Comprobante</p>
                @if($venta->ticket)
                    <a href="{{ route('ventas.ticket', $venta) }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-gray-800 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-900 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Ver Ticket
                    </a>
                    <p class="text-xs text-gray-400 mt-1">Archivo almacenado en disco privado.</p>
                @else
                    <p class="text-gray-400 text-sm">No se subió ticket para esta venta.</p>
                @endif
            </div>
        @endcan

        {{-- Botón validar — solo gerente y venta no validada --}}
        @can('validar', $venta)
            @if(!$venta->validada)
                <div class="mt-6 border-t pt-5">
                    <form method="POST" action="{{ route('ventas.validar', $venta) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                            onclick="return confirm('¿Validar esta venta? Se enviará correo al vendedor y comprador.')"
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                            ✓ Validar Venta
                        </button>
                    </form>
                </div>
            @endif
        @endcan

        <div class="flex gap-3 mt-6">
            @can('update', $venta)
                <a href="{{ route('ventas.edit', $venta) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition text-sm">
                    Editar
                </a>
            @endcan
            <a href="{{ route('ventas.index') }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection