@extends('layouts.app')
@section('title', 'Panel Empleado')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">
            🏪 Panel de Empleado
        </h1>
        <p class="text-gray-500 mt-1">Bienvenido, {{ $user->name }}. Gestiona el inventario y pedidos.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-yellow-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">📦</div>
            <h3 class="font-bold text-lg">Inventario</h3>
            <p class="text-gray-400 text-sm">Consulta y actualiza el stock de productos.</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-blue-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">📋</div>
            <h3 class="font-bold text-lg">Pedidos Pendientes</h3>
            <p class="text-gray-400 text-sm">Procesa los pedidos de clientes.</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-green-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">📊</div>
            <h3 class="font-bold text-lg">Reportes</h3>
            <p class="text-gray-400 text-sm">Consulta estadísticas de ventas.</p>
        </div>
    </div>
</div>
@endsection
