<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ── Helpers de rol ──────────────────────────────
    public function isCliente(): bool
    {
        return $this->role === 'cliente';
    }

    public function isEmpleado(): bool
    {
        return $this->role === 'empleado';
    }

    public function isGerente(): bool
    {
        return $this->role === 'gerente';
    }
}