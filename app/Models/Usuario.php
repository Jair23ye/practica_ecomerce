<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory;
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'clave',
        'rol',
    ];

    protected $hidden = [
        'clave',
    ];

    // Decirle a Laravel que la contraseña se llama 'clave'
    public function getAuthPassword()
    {
        return $this->clave;
    }

    // Relaciones 
    public function productos()
{
    return $this->hasMany(Producto::class, 'usuario_id');
}

public function ventasComoVendedor()
{
    return $this->hasMany(Venta::class, 'vendedor_id');
}

public function ventasComoCliente()
{
    return $this->hasMany(Venta::class, 'cliente_id');
}

public function categorias()
{
    return $this->hasManyThrough(
        Categoria::class,
        Producto::class,
        'usuario_id',
        'id',
        'id',
        'id'
    );
}
    

}