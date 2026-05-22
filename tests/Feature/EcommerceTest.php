<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcommerceTest extends TestCase
{
    use RefreshDatabase;

    // ── 1. Página principal ─────────────────────────────────────────────
    public function test_pagina_principal_responde_correctamente(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('pages.home');
    }

    // ── 2. Página login ─────────────────────────────────────────────────
    public function test_pagina_login_responde_correctamente(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    // ── 3. Dashboard requiere autenticación ─────────────────────────────
    public function test_dashboard_cliente_requiere_autenticacion(): void
    {
        $response = $this->get('/dashboard/cliente');

        $response->assertRedirect('/login');
    }

    // ── 4. Login incorrecto muestra error ───────────────────────────────
    public function test_login_con_credenciales_incorrectas_retorna_error(): void
    {
        $response = $this->post('/login', [
            'correo' => 'correo@incorrecto.com',
            'clave'  => 'claveincorrecta',
        ]);

        $response->assertSessionHasErrors(['correo']);
    }

    // ── 5. Registro almacenado en base de datos ─────────────────────────
    public function test_registro_nuevo_usuario_almacenado_en_bd(): void
    {
        $response = $this->post('/registro', [
            'nombre'            => 'Juan',
            'apellidos'         => 'Perez Lopez',
            'correo'            => 'juan.perez@example.com',
            'clave'             => 'password123',
            'clave_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard/cliente');

        $this->assertDatabaseHas('usuarios', [
            'correo' => 'juan.perez@example.com',
            'nombre' => 'Juan',
            'rol'    => 'cliente',
        ]);
    }

    // ── 6. Usuario autenticado accede al dashboard ──────────────────────
    public function test_usuario_autenticado_accede_al_dashboard(): void
    {
        $usuario = Usuario::factory()->cliente()->create();

        $response = $this->actingAs($usuario)->get('/dashboard/cliente');

        $response->assertStatus(200);
    }

    // ── 7. Página de registro responde correctamente ────────────────────
    public function test_pagina_registro_responde_correctamente(): void
    {
        $response = $this->get('/registro');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }
}