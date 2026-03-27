@extends('layouts.app')
@section('title', 'Ubicación')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16">
    <h1 class="text-4xl font-extrabold text-blue-700 mb-8">📍 Nuestra Ubicación</h1>
    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow p-8 space-y-4">
            <div class="flex items-start gap-3">
                <span class="text-2xl">🏢</span>
                <div>
                    <h3 class="font-bold text-lg">Dirección</h3>
                    <p class="text-gray-600">Av. Central Oriente 123, Col. Centro<br>Tuxtla Gutiérrez, Chiapas, C.P. 29000</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">🕐</span>
                <div>
                    <h3 class="font-bold text-lg">Horario de Atención</h3>
                    <p class="text-gray-600">Lunes a Viernes: 9:00 AM – 6:00 PM<br>Sábados: 9:00 AM – 2:00 PM</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">📞</span>
                <div>
                    <h3 class="font-bold text-lg">Teléfono</h3>
                    <p class="text-gray-600">+52 (961) 123-4567</p>
                </div>
            </div>
        </div>
        {{-- Mapa estático placeholder --}}
        <div class="bg-gray-200 rounded-2xl flex items-center justify-center h-64 md:h-auto">
            <p class="text-gray-500 text-center px-4">
                🗺️ Mapa interactivo<br>
                <small>(Integrar Google Maps API)</small>
            </p>
        </div>
    </div>
</div>
@endsection
