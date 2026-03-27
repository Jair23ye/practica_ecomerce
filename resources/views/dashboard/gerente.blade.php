@extends('layouts.app')
@section('title', 'Panel Gerente')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">
            ⚙️ Panel de Administración
        </h1>
        <p class="text-gray-500 mt-1">Gerente: {{ $user->name }} — Control total del sistema.</p>
    </div>

    {{-- Estadística rápida --}}
    <div class="grid md:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-600 text-white rounded-xl p-5 text-center">
            <div class="text-4xl font-bold">{{ $totalUsers }}</div>
            <div class="text-sm opacity-80 mt-1">Usuarios Totales</div>
        </div>
        <div class="bg-green-600 text-white rounded-xl p-5 text-center">
            <div class="text-4xl font-bold">0</div>
            <div class="text-sm opacity-80 mt-1">Productos</div>
        </div>
        <div class="bg-yellow-500 text-white rounded-xl p-5 text-center">
            <div class="text-4xl font-bold">0</div>
            <div class="text-sm opacity-80 mt-1">Pedidos Hoy</div>
        </div>
        <div class="bg-purple-600 text-white rounded-xl p-5 text-center">
            <div class="text-4xl font-bold">$0</div>
            <div class="text-sm opacity-80 mt-1">Ventas del Mes</div>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-red-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">👥</div>
            <h3 class="font-bold text-lg">Gestión de Usuarios</h3>
            <p class="text-gray-400 text-sm">Administra roles y permisos.</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-indigo-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">🏷️</div>
            <h3 class="font-bold text-lg">Catálogo de Productos</h3>
            <p class="text-gray-400 text-sm">Agrega, edita y elimina productos.</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-orange-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">📈</div>
            <h3 class="font-bold text-lg">Análisis de Ventas</h3>
            <p class="text-gray-400 text-sm">Reportes financieros y métricas clave.</p>
        </div>
    </div>
</div>
@endsection
