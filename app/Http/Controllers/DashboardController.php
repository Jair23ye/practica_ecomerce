<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Venta;
use App\Models\Usuario;

class DashboardController extends Controller
{
    public function cliente()
    {
        $productos = Producto::with(['usuario', 'categorias'])->get();
        return view('dashboard.cliente', compact('productos'));
    }

    public function gerente()
    {
        $this->authorize('gerenteDashboard', Usuario::class);

        $totalProductos  = Producto::count();
        $totalVentas     = Venta::count();
        $totalCategorias = Categoria::count();
        $ventas          = Venta::with(['producto', 'cliente', 'vendedor'])->latest()->take(5)->get();

        return view('dashboard.gerente', compact(
            'totalProductos', 'totalVentas', 'totalCategorias', 'ventas'
        ));
    }

    public function administrador()
    {
        $this->authorize('verEstadisticas', Usuario::class);

        // Totales usando relaciones Eloquent
        $totalUsuarios    = Usuario::count();
        $totalVendedores  = Usuario::where('rol', 'gerente')->count();
        $totalCompradores = Usuario::where('rol', 'cliente')->count();

        // Productos por categoría con withCount (relación belongsToMany)
        $productosPorCategoria = Categoria::withCount('productos')->get();

        // Producto más vendido usando withCount sobre relación hasMany
        $productoMasVendido = Producto::withCount('ventas')
            ->orderByDesc('ventas_count')
            ->first();

        // Comprador más frecuente (global) usando withCount sobre relación hasMany
        $compradorFrecuente = Usuario::where('rol', 'cliente')
            ->withCount('ventasComoCliente')
            ->orderByDesc('ventas_como_cliente_count')
            ->first();

        // Comprador más frecuente por categoría usando carga eager de relaciones Eloquent
        // Flujo: Categoria → productos (belongsToMany) → ventas (hasMany) → cliente (belongsTo)
        $categorias = Categoria::with(['productos.ventas.cliente'])->get();

        $compradorPorCategoria = $categorias->map(function ($categoria) {
            $clienteIds = $categoria->productos
                ->flatMap(fn ($p) => $p->ventas)
                ->pluck('cliente_id');

            if ($clienteIds->isEmpty()) {
                return ['categoria' => $categoria->nombre, 'comprador' => null];
            }

            $clienteIdFrecuente = $clienteIds->countBy()->sortDesc()->keys()->first();
            $comprador = Usuario::find($clienteIdFrecuente);

            return ['categoria' => $categoria->nombre, 'comprador' => $comprador];
        });

        $totalProductos  = Producto::count();
        $totalVentas     = Venta::count();
        $totalCategorias = Categoria::count();

        return view('dashboard.administrador', compact(
            'totalUsuarios',
            'totalVendedores',
            'totalCompradores',
            'totalProductos',
            'totalVentas',
            'totalCategorias',
            'productosPorCategoria',
            'productoMasVendido',
            'compradorFrecuente',
            'compradorPorCategoria'
        ));
    }
}