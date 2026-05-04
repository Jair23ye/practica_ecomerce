@extends('layouts.app')
@section('title', 'Editar Producto')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Producto</h1>

    @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('productos.update', $producto) }}" enctype="multipart/form-data"
          class="bg-white rounded-xl shadow p-8 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
            <textarea name="descripcion" rows="3"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Precio ($)</label>
                <input type="number" name="precio" value="{{ old('precio', $producto->precio) }}" step="0.01" min="0"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Existencia</label>
                <input type="number" name="existencia" value="{{ old('existencia', $producto->existencia) }}" min="0"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Categorías</label>
            <div class="flex flex-wrap gap-3">
                @foreach($categorias as $categoria)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="categorias[]" value="{{ $categoria->id }}"
                            {{ $producto->categorias->contains($categoria->id) ? 'checked' : '' }}>
                        {{ $categoria->nombre }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Fotos actuales --}}
        @if($producto->fotos && count($producto->fotos) > 0)
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-2">Fotos actuales:</p>
                <div class="flex flex-wrap gap-3">
                    @foreach($producto->fotos as $foto)
                        <img src="{{ Storage::disk('public')->url($foto) }}"
                             alt="Foto del producto"
                             class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 mt-1">Al subir nuevas fotos, las actuales serán reemplazadas.</p>
            </div>
        @endif

        {{-- Nuevas fotos --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Reemplazar fotos
                <span class="text-gray-400 font-normal">(máx. 5 imágenes, 2 MB c/u)</span>
            </label>
            <input type="file" name="fotos[]" multiple accept="image/*"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                       file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                       file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('fotos.*')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Actualizar
            </button>
            <a href="{{ route('productos.index') }}"
               class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection