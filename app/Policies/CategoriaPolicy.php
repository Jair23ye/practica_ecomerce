<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Categoria;

class CategoriaPolicy
{
    public function viewAny(Usuario $auth): bool
    {
        return true;
    }

    public function create(Usuario $auth): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente']);
    }

    public function update(Usuario $auth, Categoria $categoria): bool
    {
        return in_array($auth->rol, ['administrador', 'gerente']);
    }

    public function delete(Usuario $auth, Categoria $categoria): bool
    {
        return $auth->rol === 'administrador';
    }
}