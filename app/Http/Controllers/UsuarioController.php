<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Usuario::class);
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $this->authorize('create', Usuario::class);
        return view('usuarios.create');
    }

    public function store(StoreUsuarioRequest $request)
    {
        $this->authorize('create', Usuario::class);

        Usuario::create([
            ...$request->validated(),
            'clave' => Hash::make($request->clave),
        ]);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    public function show(Usuario $usuario)
    {
        $this->authorize('viewAny', Usuario::class);
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        $this->authorize('update', $usuario);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(StoreUsuarioRequest $request, Usuario $usuario)
    {
        $this->authorize('update', $usuario);
        $usuario->update($request->validated());
        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $this->authorize('delete', $usuario);
        $usuario->delete();
        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}