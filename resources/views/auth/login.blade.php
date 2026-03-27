@extends('layouts.app')
@section('title', 'Iniciar Sesión')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-10">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Iniciar Sesión</h2>
            <p class="text-gray-500 mb-8 text-sm">Accede a tu cuenta para continuar.</p>

            {{-- Errores generales --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                        Correo Electrónico
                    </label>
                    <input
                        id="email" name="email" type="email"
                        value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com"
                        autocomplete="email"
                        class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror
                               rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        Contraseña
                    </label>
                    <input
                        id="password" name="password" type="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        class="w-full border @error('password') border-red-400 @else border-gray-300 @enderror
                               rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Recuérdame --}}
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-600">
                        Recordar mi sesión
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg
                           hover:bg-blue-700 active:scale-95 transition text-lg">
                    Iniciar Sesión
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
