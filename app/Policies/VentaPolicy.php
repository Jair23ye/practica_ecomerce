<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Venta;

class VentaPolicy
{
    public function viewAny(Usuario $auth): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente', 'cliente']);
    }

    public function create(Usuario $auth): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente', 'cliente']);
    }

    public function update(Usuario $auth, Venta $venta): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente']);
    }

    public function delete(Usuario $auth, Venta $venta): bool
    {
        return $auth->rol === 'administrador';
    }
}