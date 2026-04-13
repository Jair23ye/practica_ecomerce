<?php

namespace App\Policies;

use App\Models\Usuario;

class UsuarioPolicy
{
    public function viewAny(Usuario $auth): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente']);
    }

    public function create(Usuario $auth): bool
    {
        return $auth->rol === 'administrador';
    }

    public function update(Usuario $auth, Usuario $usuario): bool
    {
        if ($auth->rol === 'administrador') return true;

        if ($auth->rol === 'gerente') {
            return $usuario->rol === 'cliente';
        }

        return false;
    }

    public function delete(Usuario $auth, Usuario $usuario): bool
    {
        return $auth->rol === 'administrador';
    }
}