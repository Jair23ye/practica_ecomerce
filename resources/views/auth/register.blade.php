@extends('layouts.app')
@section('title', 'Registrarse')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-10">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Crear Cuenta</h2>
            <p class="text-gray-500 mb-8 text-sm">Regístrate gratis y empieza a comprar hoy.</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name') }}" placeholder="Juan Pérez"
                           class="w-full border @error('name') border-red-400 @else border-gray-300 @enderror
                                  rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                        Correo Electrónico <span class="text-red-500">*</span>
                    </label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}" placeholder="correo@ejemplo.com"
                           class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror
                                  rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono (opcional) --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">
                        Teléfono <span class="text-gray-400 text-xs">(opcional)</span>
                    </label>
                    <input id="phone" name="phone" type="tel"
                           value="{{ old('phone') }}" placeholder="+52 961 123 4567"
                           class="w-full border @error('phone') border-red-400 @else border-gray-300 @enderror
                                  rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        Contraseña <span class="text-red-500">*</span>
                    </label>
                    <input id="password" name="password" type="password"
                           placeholder="Mínimo 8 caracteres"
                           class="w-full border @error('password') border-red-400 @else border-gray-300 @enderror
                                  rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">
                        Debe contener letras mayúsculas, minúsculas y números.
                    </p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                        Confirmar Contraseña <span class="text-red-500">*</span>
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           placeholder="Repite tu contraseña"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5
                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg
                           hover:bg-blue-700 active:scale-95 transition text-lg">
                    Crear Cuenta
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                    Inicia sesión
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
