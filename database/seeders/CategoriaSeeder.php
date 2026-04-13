<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Electrónica',   'descripcion' => 'Productos electrónicos y gadgets'],
            ['nombre' => 'Ropa',          'descripcion' => 'Ropa y accesorios de moda'],
            ['nombre' => 'Hogar',         'descripcion' => 'Artículos para el hogar'],
            ['nombre' => 'Deportes',      'descripcion' => 'Equipos y ropa deportiva'],
            ['nombre' => 'Alimentación',  'descripcion' => 'Productos alimenticios'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}