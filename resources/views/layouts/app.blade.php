<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MiTienda')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">MiTienda</a>

            <div class="hidden md:flex space-x-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Inicio</a>
                <a href="{{ route('productos.index') }}" class="hover:text-blue-600">Productos</a>
                <a href="{{ route('categorias.index') }}" class="hover:text-blue-600">Categorias</a>
                @auth
                    @if(Auth::user()->rol !== 'cliente')
                        <a href="{{ route('ventas.index') }}" class="hover:text-blue-600">Ventas</a>
                    @endif
                    @if(Auth::user()->rol === 'administrador')
                        <a href="{{ route('usuarios.index') }}" class="hover:text-blue-600">Usuarios</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center space-x-3">
                @auth
                    <span class="text-sm text-gray-500">Hola, {{ Auth::user()->nombre }}</span>
                    <span class="text-xs px-2 py-1 rounded-full font-semibold
                        @if(Auth::user()->rol === 'administrador') bg-red-100 text-red-700
                        @elseif(Auth::user()->rol === 'gerente') bg-yellow-100 text-yellow-700
                        @else bg-green-100 text-green-700 @endif">
                        {{ ucfirst(Auth::user()->rol) }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-red-600 transition">
                            Cerrar Sesion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="border border-blue-600 text-blue-600 px-4 py-1.5 rounded-lg text-sm hover:bg-blue-50 transition">
                        Iniciar Sesion
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-blue-700 transition">
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 text-center text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 text-center text-sm">
            {{ session('error') }}
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-gray-300 text-center py-6 text-sm">
        <p>&copy; {{ date('Y') }} MiTienda</p>
    </footer>

</body>
</html>