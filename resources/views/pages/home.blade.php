@extends('layouts.app')
@section('title', 'Inicio')

@section('content')
<section class="relative bg-gradient-to-br from-blue-600 to-indigo-700 text-white py-28 text-center overflow-hidden">
    <div class="relative z-10 max-w-3xl mx-auto px-4">
        <h1 class="text-5xl font-extrabold mb-4 leading-tight">
            Bienvenido a <span class="text-yellow-400">MiTienda</span>
        </h1>
        <p class="text-xl text-blue-100 mb-8">
            Tu destino de compras con la mejor calidad y servicio.
        </p>
        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ route('register') }}"
               class="bg-yellow-400 text-gray-900 font-bold px-8 py-3 rounded-full hover:bg-yellow-300 transition text-lg">
                Crear Cuenta
            </a>
            <a href="{{ route('about') }}"
               class="border-2 border-white text-white px-8 py-3 rounded-full hover:bg-white hover:text-blue-700 transition text-lg">
                Conócenos
            </a>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 py-16 grid md:grid-cols-3 gap-8 text-center">
    <div class="bg-white rounded-2xl shadow p-8 hover:shadow-lg transition">
        <div class="text-5xl mb-4">🚚</div>
        <h3 class="text-xl font-bold mb-2">Envíos Rápidos</h3>
        <p class="text-gray-500">Entregamos tu pedido en tiempo récord a toda la república.</p>
    </div>
    <div class="bg-white rounded-2xl shadow p-8 hover:shadow-lg transition">
        <div class="text-5xl mb-4">🛡️</div>
        <h3 class="text-xl font-bold mb-2">Compra Segura</h3>
        <p class="text-gray-500">Tus datos y pagos siempre protegidos con cifrado SSL.</p>
    </div>
    <div class="bg-white rounded-2xl shadow p-8 hover:shadow-lg transition">
        <div class="text-5xl mb-4">🎁</div>
        <h3 class="text-xl font-bold mb-2">Promociones Exclusivas</h3>
        <p class="text-gray-500">Descuentos y ofertas especiales para nuestros clientes registrados.</p>
    </div>
</section>
@endsection
