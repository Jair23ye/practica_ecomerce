<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Mostrar formulario de login ──────────────────
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    // ── Procesar inicio de sesión ────────────────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user()->role)
                        ->with('success', '¡Bienvenido, ' . Auth::user()->name . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    // ── Mostrar formulario de registro ───────────────
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.register');
    }

    // ── Procesar registro ────────────────────────────
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:100',
                           'regex:/^[\pL\s\-]+$/u'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'regex:/^[0-9\+\-\s]{7,15}$/'],
            'password' => ['required', 'confirmed',
                           Password::min(8)
                               ->letters()
                               ->numbers()
                               ->mixedCase()],
        ], [
            'name.required'           => 'El nombre es obligatorio.',
            'name.min'                => 'El nombre debe tener al menos 3 caracteres.',
            'name.max'                => 'El nombre no puede superar 100 caracteres.',
            'name.regex'              => 'El nombre solo puede contener letras y espacios.',
            'email.required'          => 'El correo electrónico es obligatorio.',
            'email.email'             => 'Ingresa un correo electrónico válido.',
            'email.unique'            => 'Este correo ya está registrado.',
            'phone.regex'             => 'Ingresa un número de teléfono válido.',
            'password.required'       => 'La contraseña es obligatoria.',
            'password.confirmed'      => 'Las contraseñas no coinciden.',
            'password.min'            => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => $request->role ?? 'cliente', // Todo registro público es cliente
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.cliente')
                         ->with('success', '¡Cuenta creada exitosamente! Bienvenido.');
    }

    // ── Cerrar sesión ────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
                         ->with('success', 'Has cerrado sesión correctamente.');
    }

    // ── Helper: redirigir según rol ──────────────────
    private function redirectByRole(string $role)
    {
        return match ($role) {
            'gerente'  => redirect()->route('dashboard.gerente'),
            'empleado' => redirect()->route('dashboard.empleado'),
            default    => redirect()->route('dashboard.cliente'),
        };
    }
}
