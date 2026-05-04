<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        $productos = [
            'Laptop', 'Smartphone', 'Tablet', 'Monitor', 'Teclado', 'Mouse', 'Audífonos',
            'Cámara', 'Impresora', 'Proyector', 'Televisor', 'Refrigerador', 'Licuadora',
            'Cafetera', 'Microondas', 'Ventilador', 'Silla', 'Mesa', 'Lámpara', 'Mochila',
            'Zapatos', 'Camisa', 'Pantalón', 'Reloj', 'Bolsa', 'Perfume', 'Libro',
            'Pelota', 'Raqueta', 'Bicicleta',
        ];

        return [
            'nombre'      => $this->faker->randomElement($productos) . ' ' . $this->faker->word(),
            'descripcion' => $this->faker->sentence(10),
            'precio'      => $this->faker->randomFloat(2, 50, 15000),
            'existencia'  => $this->faker->numberBetween(1, 100),
            'usuario_id'  => null,
            'fotos'       => null,
        ];
    }
}