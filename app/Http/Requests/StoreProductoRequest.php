<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'min:3', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'precio'      => ['required', 'numeric', 'min:0'],
            'existencia'  => ['required', 'integer', 'min:0'],
            'categorias'  => ['required', 'array'],
            'categorias.*'=> ['exists:categorias,id'],
        ];
    }
}