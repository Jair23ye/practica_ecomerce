@extends('layouts.app')
@section('title', 'Verificación de Dos Factores')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-10">

            <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>

            <h2 class="text-3xl font-extrabold text-gray-800 mb-1 text-center">Verificación 2FA</h2>
            <p class="text-center text-gray-500 text-sm mb-6">
                Te enviamos un código de 6 dígitos a tu correo. Expira en <strong>5 minutos</strong>.
            </p>

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-300 text-blue-700 rounded-lg px-4 py-3 mb-4 text-sm">
                    {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.verificar-2fa.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-1">
                        Código de verificación
                    </label>
                    <input id="codigo" name="codigo" type="text"
                        inputmode="numeric" maxlength="6"
                        placeholder="000000"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-center text-2xl
                               tracking-widest font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('codigo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition text-lg">
                    Verificar Código
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿Código incorrecto?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                    Volver al login
                </a>
            </p>
        </div>
    </div>
</div>
@endsection