<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Administrador fijo ──────────────────────────────────────────
        Usuario::create([
            'nombre'    => 'Admin',
            'apellidos' => 'Sistema',
            'correo'    => 'admin@tuxtla.tecnm.mx',
            'clave'     => Hash::make('123'),
            'rol'       => 'administrador',
        ]);

        Usuario::create([
            'nombre'    => 'Mauricio',
            'apellidos' => 'Reyes Gonzalez',
            'correo'    => 'reyesgonzalezmauriciojair10@gmail.com',
            'clave'     => Hash::make('123'),
            'rol'       => 'administrador',
        ]);

        // Cuenta gerente fija para pruebas de validación de ventas
        Usuario::create([
            'nombre'    => 'Mauricio',
            'apellidos' => 'Gerente',
            'correo'    => 'gerente@tienda.com',
            'clave'     => Hash::make('123'),
            'rol'       => 'gerente',
        ]);

        // ── 30 gerentes (vendedores) + 70 clientes (compradores) ───────
        $gerentes = Usuario::factory(30)->gerente()->create();
        $clientes = Usuario::factory(70)->cliente()->create();

        // ── Categorías ─────────────────────────────────────────────────
        $this->call(CategoriaSeeder::class);
        $categorias = Categoria::all();

        // ── Productos: mínimo 3 por gerente, cada uno con ≥1 categoría ─
        $gerentes->each(function (Usuario $gerente) use ($categorias) {
            $numProductos = rand(3, 6);
            for ($i = 0; $i < $numProductos; $i++) {
                $producto = Producto::factory()->create(['usuario_id' => $gerente->id]);

                $producto->categorias()->attach(
                    $categorias->random(rand(1, 3))->pluck('id')->toArray()
                );
            }
        });

        // ── Ventas: cada cliente compra entre 1 y 5 productos ──────────
        $productos = Producto::all();

        $clientes->each(function (Usuario $cliente) use ($productos) {
            $numVentas = rand(1, 5);
            for ($i = 0; $i < $numVentas; $i++) {
                $producto = $productos->random();

                Venta::factory()->create([
                    'producto_id' => $producto->id,
                    'vendedor_id' => $producto->usuario_id,
                    'cliente_id'  => $cliente->id,
                    'total'       => $producto->precio * rand(1, 3),
                ]);
            }
        });
    }
}