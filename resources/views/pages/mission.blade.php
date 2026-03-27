@extends('layouts.app')
@section('title', 'Misión y Visión')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16 space-y-10">
    <div class="bg-blue-50 border-l-4 border-blue-600 rounded-2xl p-10">
        <h2 class="text-3xl font-extrabold text-blue-700 mb-4">🎯 Nuestra Misión</h2>
        <p class="text-gray-600 text-lg leading-relaxed">
            Ofrecer una plataforma de comercio electrónico accesible, confiable y eficiente que
            conecte a compradores y vendedores, simplificando el proceso de compra y garantizando
            una experiencia excepcional para cada usuario.
        </p>
    </div>
    <div class="bg-indigo-50 border-l-4 border-indigo-600 rounded-2xl p-10">
        <h2 class="text-3xl font-extrabold text-indigo-700 mb-4">🔭 Nuestra Visión</h2>
        <p class="text-gray-600 text-lg leading-relaxed">
            Convertirnos en el e-commerce de referencia en México, reconocido por nuestra
            innovación tecnológica, variedad de productos y compromiso con la satisfacción del
            cliente, expandiendo nuestra presencia a toda Latinoamérica para 2030.
        </p>
    </div>
    <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-2xl p-10">
        <h2 class="text-3xl font-extrabold text-yellow-700 mb-4">💎 Nuestros Valores</h2>
        <ul class="space-y-2 text-gray-600 text-lg">
            <li>✔️ <strong>Integridad</strong> — Actuamos con honestidad en todo momento.</li>
            <li>✔️ <strong>Innovación</strong> — Mejoramos continuamente nuestra tecnología.</li>
            <li>✔️ <strong>Servicio</strong> — El cliente siempre es nuestra prioridad.</li>
            <li>✔️ <strong>Sustentabilidad</strong> — Comprometidos con el medio ambiente.</li>
        </ul>
    </div>
</div>
@endsection
