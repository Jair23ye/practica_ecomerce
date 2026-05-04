<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Venta;

class VentaPolicy
{
    public function viewAny(Usuario $auth): bool
    {
        return true;
    }

    // Solo el dueño de la venta (cliente o vendedor) o gerente puede ver la venta
    public function view(Usuario $auth, Venta $venta): bool
    {
        return $auth->rol === 'gerente'
            || $auth->id === $venta->cliente_id
            || $auth->id === $venta->vendedor_id;
    }

    public function create(Usuario $auth): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente', 'cliente']);
    }

    public function update(Usuario $auth, Venta $_venta): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente']);
    }

    public function delete(Usuario $auth, Venta $_venta): bool
    {
        return $auth->rol === 'administrador';
    }

    // Solo el dueño de la venta o gerente puede ver el ticket privado
    public function verTicket(Usuario $auth, Venta $venta): bool
    {
        return $auth->rol === 'gerente'
            || $auth->id === $venta->cliente_id
            || $auth->id === $venta->vendedor_id;
    }

    // Solo gerente puede validar una venta
    public function validar(Usuario $auth, Venta $venta): bool
    {
        return $auth->rol === 'gerente';
    }
}