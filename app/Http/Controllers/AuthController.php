<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->rol);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo'   => ['required', 'email'],
            'clave'    => ['required'],
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email'    => 'Ingresa un correo válido.',
            'clave.required'  => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['clave']])) {
            $request->session()->regenerate();

            Log::channel('autenticacion')->info('Login exitoso', [
                'usuario_id' => Auth::user()->id,
                'correo'     => Auth::user()->correo,
                'ip'         => $request->ip(),
            ]);

            return $this->redirectByRole(Auth::user()->rol)
                        ->with('success', '¡Bienvenido, ' . Auth::user()->nombre . '!');
        }

        Log::channel('autenticacion')->warning('Login fallido', [
            'correo' => $request->correo,
            'ip'     => $request->ip(),
        ]);

        return back()
            ->withInput($request->only('correo'))
            ->withErrors(['correo' => 'Las credenciales no coinciden.']);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->rol);
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => ['required', 'string', 'min:3', 'max:100'],
            'apellidos'=> ['required', 'string', 'min:3', 'max:100'],
            'correo'   => ['required', 'email', 'unique:usuarios,correo'],
            'clave'    => ['required', 'confirmed', 'min:6'],
        ]);

        $usuario = Usuario::create([
            'nombre'   => $validated['nombre'],
            'apellidos'=> $validated['apellidos'],
            'correo'   => $validated['correo'],
            'clave'    => Hash::make($validated['clave']),
            'rol'      => 'cliente',
        ]);

        Auth::login($usuario);

        return redirect()->route('dashboard.cliente')
                         ->with('success', '¡Cuenta creada exitosamente!');
    }

    public function logout(Request $request)
    {
        Log::channel('autenticacion')->info('Logout', [
            'usuario_id' => Auth::user()->id,
            'correo'     => Auth::user()->correo,
            'ip'         => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
                         ->with('success', 'Has cerrado sesión correctamente.');
    }

    private function redirectByRole(string $rol)
    {
        return match ($rol) {
            'administrador' => redirect()->route('dashboard.administrador'),
            'gerente'       => redirect()->route('dashboard.gerente'),
            default         => redirect()->route('dashboard.cliente'),
        };
    }
}