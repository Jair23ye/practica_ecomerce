@extends('layouts.app')
@section('title', 'Contacto')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16">
    <h1 class="text-4xl font-extrabold text-blue-700 mb-8">📬 Contáctanos</h1>
    <div class="bg-white rounded-2xl shadow p-10">
        <form class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre completo</label>
                <input type="text" placeholder="Tu nombre"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" placeholder="correo@ejemplo.com"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mensaje</label>
                <textarea rows="5" placeholder="Escribe tu mensaje..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                Enviar Mensaje
            </button>
        </form>
        <div class="mt-8 pt-6 border-t border-gray-100 text-sm text-gray-500 space-y-1">
            <p>📧 contacto@mitienda.com</p>
            <p>📞 +52 (961) 123-4567</p>
            <p>📱 WhatsApp: +52 961 234 5678</p>
        </div>
    </div>
</div>
@endsection
