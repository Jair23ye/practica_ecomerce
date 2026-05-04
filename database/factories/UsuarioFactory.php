<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        $nombres   = ['Juan', 'Mario', 'Maria', 'Pedro', 'Ana', 'Luis', 'Rosa', 'Carlos',
                      'Sofia', 'Jorge', 'Elena', 'Miguel', 'Laura', 'Diego', 'Claudia'];
        $apellidos = ['Lopez', 'Sanchez', 'Hernandez', 'Martinez', 'Garcia', 'Perez',
                      'Torres', 'Ramirez', 'Flores', 'Reyes', 'Cruz', 'Morales'];

        $nombre   = $this->faker->randomElement($nombres);
        $apellido = $this->faker->randomElement($apellidos);
        $uid      = $this->faker->unique()->numberBetween(1, 9999);

        return [
            'nombre'    => $nombre,
            'apellidos' => $apellido,
            'correo'    => strtolower(substr($nombre, 0, 1) . $apellido . $uid) . '@tuxtla.tecnm.mx',
            'clave'     => Hash::make('123'),
            'rol'       => 'cliente',
        ];
    }

    public function cliente(): static
    {
        return $this->state(['rol' => 'cliente']);
    }

    public function gerente(): static
    {
        return $this->state(['rol' => 'gerente']);
    }
}