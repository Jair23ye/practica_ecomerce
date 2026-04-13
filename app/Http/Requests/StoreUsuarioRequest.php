<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'    => ['required', 'string', 'min:3', 'max:100'],
            'apellidos' => ['required', 'string', 'min:3', 'max:100'],
            'correo'    => ['required', 'email', 'unique:usuarios,correo'],
            'clave'     => ['required', 'string', 'min:6', 'confirmed'],
            'rol'       => ['required', 'in:administrador,gerente,cliente'],
        ];
    }
}