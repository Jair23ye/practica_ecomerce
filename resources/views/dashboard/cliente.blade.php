@extends('layouts.app')
@section('title', 'Mi Dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">
            👋 Hola, {{ $user->name }}
        </h1>
        <p class="text-gray-500 mt-1">Panel de Cliente — gestiona tus pedidos y perfil.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-blue-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">🛍️</div>
            <h3 class="font-bold text-lg">Mis Pedidos</h3>
            <p class="text-gray-400 text-sm">Revisa el estado de tus compras.</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-green-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">❤️</div>
            <h3 class="font-bold text-lg">Lista de Deseos</h3>
            <p class="text-gray-400 text-sm">Productos guardados para después.</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6 border-t-4 border-purple-500 hover:shadow-lg transition cursor-pointer">
            <div class="text-4xl mb-3">👤</div>
            <h3 class="font-bold text-lg">Mi Perfil</h3>
            <p class="text-gray-400 text-sm">Actualiza tus datos personales.</p>
        </div>
    </div>
</div>
@endsection
