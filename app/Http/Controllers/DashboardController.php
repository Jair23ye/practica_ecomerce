<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        $totalProductos  = Producto::count();
        $totalVentas     = Venta::count();
        $totalCategorias = Categoria::count();
        $ventas          = Venta::with(['producto', 'cliente', 'vendedor'])->latest()->take(5)->get();
        return view('dashboard.gerente', compact('totalProductos', 'totalVentas', 'totalCategorias', 'ventas'));
    }

    public function administrador()
    {
        $totalUsuarios   = Usuario::count();
        $totalProductos  = Producto::count();
        $totalVentas     = Venta::count();
        $totalCategorias = Categoria::count();
        return view('dashboard.administrador', compact('totalUsuarios', 'totalProductos', 'totalVentas', 'totalCategorias'));
    }
}