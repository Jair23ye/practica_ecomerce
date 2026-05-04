<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Producto::class);
        $productos = Producto::with(['usuario', 'categorias'])->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $this->authorize('create', Producto::class);
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(StoreProductoRequest $request)
    {
        $this->authorize('create', Producto::class);

        $fotos = [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $fotos[] = $foto->store('productos', 'public');
            }
        }

        $producto = Producto::create([
            ...$request->safe()->except('categorias', 'fotos'),
            'usuario_id' => Auth::id(),
            'fotos'      => $fotos ?: null,
        ]);

        $producto->categorias()->attach($request->categorias);

        Log::channel('productos')->info('Producto creado', [
            'producto_id' => $producto->id,
            'nombre'      => $producto->nombre,
            'usuario_id'  => Auth::id(),
        ]);

        return redirect()->route('productos.index')
                         ->with('success', 'Producto creado correctamente.');
    }

    public function show(Producto $producto)
    {
        $this->authorize('viewAny', Producto::class);
        $producto->load(['usuario', 'categorias', 'ventas']);
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $this->authorize('update', $producto);

        $fotos = $producto->fotos ?? [];

        if ($request->hasFile('fotos')) {
            // Eliminar fotos anteriores del disco público
            foreach ($fotos as $fotoAnterior) {
                Storage::disk('public')->delete($fotoAnterior);
            }
            $fotos = [];
            foreach ($request->file('fotos') as $foto) {
                $fotos[] = $foto->store('productos', 'public');
            }
        }

        $producto->update([
            ...$request->safe()->except('categorias', 'fotos'),
            'fotos' => $fotos ?: null,
        ]);

        $producto->categorias()->sync($request->categorias);

        Log::channel('productos')->info('Producto editado', [
            'producto_id' => $producto->id,
            'nombre'      => $producto->nombre,
            'usuario_id'  => Auth::id(),
        ]);

        return redirect()->route('productos.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        // Eliminar fotos del disco público
        foreach ($producto->fotos ?? [] as $foto) {
            Storage::disk('public')->delete($foto);
        }

        Log::channel('productos')->warning('Producto eliminado', [
            'producto_id' => $producto->id,
            'nombre'      => $producto->nombre,
            'usuario_id'  => Auth::id(),
        ]);

        $producto->delete();

        return redirect()->route('productos.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }
}