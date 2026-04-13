<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'producto_id' => ['required', 'integer', 'exists:productos,id'],
            'cliente_id'  => ['required', 'integer', 'exists:usuarios,id'],
            'fecha'       => ['required', 'date'],
            'total'       => ['required', 'numeric', 'min:0'],
        ];
    }
}