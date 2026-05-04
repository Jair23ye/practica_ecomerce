@extends('layouts.app')
@section('title', 'Editar Venta')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Venta #{{ $venta->id }}</h1>

    @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('ventas.update', $venta) }}" enctype="multipart/form-data"
          class="bg-white rounded-xl shadow p-8 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Producto</label>
            <select name="producto_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $venta->producto_id == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre }} — ${{ number_format($producto->precio, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Cliente</label>
            <select name="cliente_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }} {{ $cliente->apellidos }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha</label>
                <input type="date" name="fecha" value="{{ old('fecha', $venta->fecha) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Total ($)</label>
                <input type="number" name="total" value="{{ old('total', $venta->total) }}" step="0.01" min="0"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Ticket actual --}}
        @if($venta->ticket)
            <div class="bg-amber-50 border border-amber-200 rounded-lg px-4 py-3 text-sm">
                <p class="font-semibold text-amber-800 mb-1">Ticket actual registrado</p>
                @can('verTicket', $venta)
                    <a href="{{ route('ventas.ticket', $venta) }}" target="_blank"
                       class="text-blue-600 hover:underline text-xs">Ver ticket actual</a>
                @endcan
                <p class="text-amber-600 text-xs mt-1">Al subir uno nuevo, el actual será reemplazado.</p>
            </div>
        @endif

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                {{ $venta->ticket ? 'Reemplazar ticket' : 'Subir ticket / Comprobante' }}
                <span class="text-gray-400 font-normal">(imagen, máx. 4 MB)</span>
            </label>
            <input type="file" name="ticket" accept="image/*"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                       file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                       file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            @error('ticket')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Actualizar
            </button>
            <a href="{{ route('ventas.index') }}"
               class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection