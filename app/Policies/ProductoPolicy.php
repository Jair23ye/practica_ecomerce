<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Producto;

class ProductoPolicy
{
    public function viewAny(Usuario $auth): bool
    {
        return true;
    }

    public function create(Usuario $auth): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente']);
    }

    public function update(Usuario $auth, Producto $producto): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente']);
    }

    public function delete(Usuario $auth, Producto $producto): bool
    {
        return $auth->rol === 'administrador';
    }
}