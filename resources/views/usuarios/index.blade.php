@extends('layouts.app')
@section('title', 'Usuarios')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Usuarios</h1>
        @can('create', App\Models\Usuario::class)
            <a href="{{ route('usuarios.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Nuevo Usuario
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Correo</th>
                    <th class="px-6 py-3 text-left">Rol</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($usuarios as $usuario)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $usuario->id }}</td>
                        <td class="px-6 py-4">{{ $usuario->nombre }} {{ $usuario->apellidos }}</td>
                        <td class="px-6 py-4">{{ $usuario->correo }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($usuario->rol === 'administrador') bg-red-100 text-red-700
                                @elseif($usuario->rol === 'gerente') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700 @endif">
                                {{ ucfirst($usuario->rol) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('usuarios.show', $usuario) }}"
                                   class="text-sm bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">Ver</a>
                                @can('update', $usuario)
                                    <a href="{{ route('usuarios.edit', $usuario) }}"
                                       class="text-sm bg-yellow-100 px-3 py-1 rounded hover:bg-yellow-200">Editar</a>
                                @endcan
                                @can('delete', $usuario)
                                    <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Eliminar usuario?')"
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
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection