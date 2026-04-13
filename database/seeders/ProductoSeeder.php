<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $vendedor = Usuario::where('rol', 'gerente')->first();

        if (!$vendedor) {
            $vendedor = Usuario::first();
        }

        $productos = [
            [
                'nombre'      => 'Laptop HP',
                'descripcion' => 'Laptop HP 15 pulgadas 8GB RAM',
                'precio'      => 12000.00,
                'existencia'  => 10,
            ],
            [
                'nombre'      => 'Tenis Nike',
                'descripcion' => 'Tenis deportivos talla 27',
                'precio'      => 1500.00,
                'existencia'  => 25,
            ],
            [
                'nombre'      => 'Cafetera',
                'descripcion' => 'Cafetera eléctrica 12 tazas',
                'precio'      => 800.00,
                'existencia'  => 15,
            ],
        ];

        $categorias = Categoria::all();

        foreach ($productos as $data) {
            $producto = Producto::create([
                ...$data,
                'usuario_id' => $vendedor->id,
            ]);

            // Asignar 1 o 2 categorías aleatorias
            $producto->categorias()->attach(
                $categorias->random(rand(1, 2))->pluck('id')->toArray()
            );
        }
    }
}