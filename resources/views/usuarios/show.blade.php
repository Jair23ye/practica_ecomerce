@extends('layouts.app')
@section('title', 'Detalle Usuario')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $usuario->nombre }} {{ $usuario->apellidos }}</h1>

        <div class="space-y-3 text-sm text-gray-700">
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold">Correo:</span>
                <span>{{ $usuario->correo }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold">Rol:</span>
                <span class="px-2 py-1 rounded-full text-xs font-semibold
                    @if($usuario->rol === 'administrador') bg-red-100 text-red-700
                    @elseif($usuario->rol === 'gerente') bg-yellow-100 text-yellow-700
                    @else bg-green-100 text-green-700 @endif">
                    {{ ucfirst($usuario->rol) }}
                </span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold">Productos registrados:</span>
                <span>{{ $usuario->productos->count() }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold">Ventas como vendedor:</span>
                <span>{{ $usuario->ventasComoVendedor->count() }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Ventas como cliente:</span>
                <span>{{ $usuario->ventasComoCliente->count() }}</span>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            @can('update', $usuario)
                <a href="{{ route('usuarios.edit', $usuario) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                    Editar
                </a>
            @endcan
            <a href="{{ route('usuarios.index') }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection