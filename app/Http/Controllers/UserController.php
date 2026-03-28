<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * LEER: Listar todos los usuarios (GET)
     */
    public function index()
    {
        $usuarios = User::all();
        return response()->json($usuarios, 200);
    }

    /**
     * LEER UNO: Ver un usuario específico (GET)
     */
    public function show(User $usuario)
    {
        return response()->json($usuario, 200);
    }

    /**
     * ACTUALIZAR: Cambiar datos de un usuario (PUT)
     */
    public function update(Request $request, User $usuario)
    {
        // Validamos lo que llega de Postman
        $validated = $request->validate([
            'name'  => 'string|max:100',
            'email' => 'email|unique:users,email,' . $usuario->id,
            'phone' => 'nullable|string',
            'role'  => 'in:cliente,empleado,gerente',
        ]);

        $usuario->update($validated);

        return response()->json([
            'message' => 'Usuario actualizado con éxito',
            'user' => $usuario
        ], 200);
    }

    /**
     * ELIMINAR: Borrar un usuario (DELETE)
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ], 200);
    }
}