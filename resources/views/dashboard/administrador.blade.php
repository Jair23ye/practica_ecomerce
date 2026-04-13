@extends('layouts.app')
@section('title', 'Dashboard Administrador')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Panel Administrador</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-4xl font-bold text-blue-600">{{ $totalUsuarios }}</p>
            <p class="text-gray-500 mt-1">Usuarios</p>
        </div>
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('usuarios.index') }}"
           class="bg-blue-600 text-white px-6 py-4 rounded-xl text-center font-bold hover:bg-blue-700 transition">
            Gestionar Usuarios
        </a>
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
</div>
@endsection