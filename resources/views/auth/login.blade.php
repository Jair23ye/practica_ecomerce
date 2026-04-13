@extends('layouts.app')
@section('title', 'Iniciar Sesion')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-10">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Iniciar Sesion</h2>

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
                <div>
                    <label for="correo" class="block text-sm font-semibold text-gray-700 mb-1">Correo</label>
                    <input id="correo" name="correo" type="email"
                        value="{{ old('correo') }}"
                        placeholder="correo@ejemplo.com"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('correo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="clave" class="block text-sm font-semibold text-gray-700 mb-1">Contrasena</label>
                    <input id="clave" name="clave" type="password"
                        placeholder="********"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('clave')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition text-lg">
                    Iniciar Sesion
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                No tienes cuenta?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                    Registrate aqui
                </a>
            </p>
        </div>
    </div>
</div>
@endsection