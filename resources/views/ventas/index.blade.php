@extends('layouts.app')
@section('title', 'Ventas')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ventas</h1>
        @can('create', App\Models\Venta::class)
            <a href="{{ route('ventas.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Nueva Venta
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Producto</th>
                    <th class="px-6 py-3 text-left">Cliente</th>
                    <th class="px-6 py-3 text-left">Vendedor</th>
                    <th class="px-6 py-3 text-left">Fecha</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($ventas as $venta)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $venta->id }}</td>
                        <td class="px-6 py-4">{{ $venta->producto->nombre }}</td>
                        <td class="px-6 py-4">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</td>
                        <td class="px-6 py-4">{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</td>
                        <td class="px-6 py-4">{{ $venta->fecha }}</td>
                        <td class="px-6 py-4 text-blue-600 font-bold">${{ number_format($venta->total, 2) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('ventas.show', $venta) }}"
                                   class="text-sm bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">Ver</a>
                                @can('update', $venta)
                                    <a href="{{ route('ventas.edit', $venta) }}"
                                       class="text-sm bg-yellow-100 px-3 py-1 rounded hover:bg-yellow-200">Editar</a>
                                @endcan
                                @can('delete', $venta)
                                    <form method="POST" action="{{ route('ventas.destroy', $venta) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Eliminar venta?')"
                                            class="text-sm bg-red-100 px-3 py-1 rounded hover:bg-red-200">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay ventas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection