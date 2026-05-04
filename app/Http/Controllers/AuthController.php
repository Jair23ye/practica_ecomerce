<?php

namespace App\Http\Controllers;

use App\Mail\CodigoVerificacionMail;
use App\Models\CodigoVerificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // ────────────────────────────────────────────────
    // FASE 1: validar credenciales y generar código OTP
    // ────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->rol);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => ['required', 'email'],
            'clave'  => ['required'],
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email'    => 'Ingresa un correo válido.',
            'clave.required'  => 'La contraseña es obligatoria.',
        ]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario || !Hash::check($request->clave, $usuario->getAuthPassword())) {
            Log::channel('autenticacion')->warning('Login fallido (credenciales incorrectas)', [
                'correo' => $request->correo,
                'ip'     => $request->ip(),
            ]);

            return back()
                ->withInput($request->only('correo'))
                ->withErrors(['correo' => 'Las credenciales no coinciden.']);
        }

        Log::channel('autenticacion')->info('Login correcto (fase 1) - pendiente 2FA', [
            'usuario_id' => $usuario->id,
            'correo'     => $usuario->correo,
            'ip'         => $request->ip(),
        ]);

        // Eliminar códigos anteriores y generar nuevo OTP
        CodigoVerificacion::where('usuario_id', $usuario->id)->delete();

        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        CodigoVerificacion::create([
            'usuario_id' => $usuario->id,
            'codigo'     => $codigo,
            'expiracion' => now()->addMinutes(5),
        ]);

        Log::channel('autenticacion')->info('Código 2FA generado', [
            'usuario_id' => $usuario->id,
            'ip'         => $request->ip(),
        ]);

        Mail::to($usuario->correo)->send(new CodigoVerificacionMail($codigo, $usuario->nombre));

        // Guardar el ID en sesión para la fase 2 (sin autenticar aún)
        $request->session()->put('2fa_usuario_id', $usuario->id);

        return redirect()->route('auth.verificar-2fa')
                         ->with('info', 'Ingresa el código de 6 dígitos enviado a tu correo.');
    }

    // ────────────────────────────────────────────────
    // FASE 2: validar código OTP y completar login
    // ────────────────────────────────────────────────

    public function showVerificar2FA()
    {
        if (!session('2fa_usuario_id')) {
            return redirect()->route('login');
        }
        return view('auth.verificar-2fa');
    }

    public function verificar2FA(Request $request)
    {
        $request->validate([
            'codigo' => ['required', 'digits:6'],
        ], [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.digits'   => 'El código debe tener exactamente 6 dígitos.',
        ]);

        $usuarioId = $request->session()->get('2fa_usuario_id');

        if (!$usuarioId) {
            return redirect()->route('login')
                             ->withErrors(['correo' => 'Sesión expirada. Inicia sesión nuevamente.']);
        }

        $registro = CodigoVerificacion::where('usuario_id', $usuarioId)->latest()->first();

        if (!$registro) {
            return redirect()->route('login')
                             ->withErrors(['correo' => 'No se encontró un código activo. Intenta de nuevo.']);
        }

        if ($registro->estaVencido()) {
            Log::channel('autenticacion')->warning('Código 2FA expirado', [
                'usuario_id' => $usuarioId,
                'ip'         => $request->ip(),
            ]);

            $registro->delete();
            $request->session()->forget('2fa_usuario_id');

            return redirect()->route('login')
                             ->withErrors(['correo' => 'El código ha expirado. Inicia sesión nuevamente.']);
        }

        if ($registro->codigo !== $request->codigo) {
            Log::channel('autenticacion')->warning('Código 2FA inválido', [
                'usuario_id'       => $usuarioId,
                'codigo_ingresado' => $request->codigo,
                'ip'               => $request->ip(),
            ]);

            return back()->withErrors(['codigo' => 'Código incorrecto. Inténtalo de nuevo.']);
        }

        // Código correcto → completar autenticación
        Log::channel('autenticacion')->info('Código 2FA validado correctamente - Login completo', [
            'usuario_id' => $usuarioId,
            'ip'         => $request->ip(),
        ]);

        $registro->delete();
        $request->session()->forget('2fa_usuario_id');

        $usuario = Usuario::findOrFail($usuarioId);
        Auth::login($usuario);
        $request->session()->regenerate();

        return $this->redirectByRole($usuario->rol)
                    ->with('success', '¡Bienvenido, ' . $usuario->nombre . '!');
    }

    // ────────────────────────────────────────────────
    // REGISTRO
    // ────────────────────────────────────────────────

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
            'nombre'    => ['required', 'string', 'min:3', 'max:100'],
            'apellidos' => ['required', 'string', 'min:3', 'max:100'],
            'correo'    => ['required', 'email', 'unique:usuarios,correo'],
            'clave'     => ['required', 'confirmed', 'min:6'],
        ]);

        $usuario = Usuario::create([
            'nombre'    => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'correo'    => $validated['correo'],
            'clave'     => Hash::make($validated['clave']),
            'rol'       => 'cliente',
        ]);

        Auth::login($usuario);

        return redirect()->route('dashboard.cliente')
                         ->with('success', '¡Cuenta creada exitosamente!');
    }

    // ────────────────────────────────────────────────
    // LOGOUT
    // ────────────────────────────────────────────────

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