<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Venta;
use App\Policies\UsuarioPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\CategoriaPolicy;
use App\Policies\VentaPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Usuario::class  => UsuarioPolicy::class,
        Producto::class => ProductoPolicy::class,
        Categoria::class => CategoriaPolicy::class,
        Venta::class    => VentaPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}