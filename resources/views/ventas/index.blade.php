@extends('layouts.app')
@section('title', 'Ventas')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ventas</h1>
        @can('create', App\Models\Venta::class)
            <a href="{{ route('ventas.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                + Nueva Venta
            </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Producto</th>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th class="px-4 py-3 text-center">Estado</th>
                    <th class="px-4 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($ventas as $venta)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">{{ $venta->id }}</td>
                        <td class="px-4 py-3 font-medium">{{ $venta->producto->nombre }}</td>
                        <td class="px-4 py-3">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $venta->fecha }}</td>
                        <td class="px-4 py-3 text-blue-600 font-bold">${{ number_format($venta->total, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($venta->validada)
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">
                                    Validada
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded-full">
                                    Pendiente
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-1 flex-wrap">
                                <a href="{{ route('ventas.show', $venta) }}"
                                   class="text-xs bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">Ver</a>

                                @can('verTicket', $venta)
                                    @if($venta->ticket)
                                        <a href="{{ route('ventas.ticket', $venta) }}" target="_blank"
                                           class="text-xs bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-900">
                                            Ticket
                                        </a>
                                    @endif
                                @endcan

                                @can('validar', $venta)
                                    @if(!$venta->validada)
                                        <form method="POST" action="{{ route('ventas.validar', $venta) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('¿Validar venta #{{ $venta->id }}?')"
                                                class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                                Validar
                                            </button>
                                        </form>
                                    @endif
                                @endcan

                                @can('update', $venta)
                                    <a href="{{ route('ventas.edit', $venta) }}"
                                       class="text-xs bg-yellow-100 px-3 py-1 rounded hover:bg-yellow-200">Editar</a>
                                @endcan

                                @can('delete', $venta)
                                    <form method="POST" action="{{ route('ventas.destroy', $venta) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Eliminar venta?')"
                                            class="text-xs bg-red-100 px-3 py-1 rounded hover:bg-red-200">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                            No hay ventas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection