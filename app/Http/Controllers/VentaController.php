<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Usuario;
use App\Http\Requests\StoreVentaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VentaController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Venta::class);
        $ventas = Venta::with(['producto', 'cliente', 'vendedor'])->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $this->authorize('create', Venta::class);
        $productos = Producto::all();
        $clientes  = Usuario::where('rol', 'cliente')->get();
        return view('ventas.create', compact('productos', 'clientes'));
    }

    public function store(StoreVentaRequest $request)
    {
        $this->authorize('create', Venta::class);

        $venta = Venta::create([
            ...$request->validated(),
            'vendedor_id' => Auth::id(),
        ]);

        Log::channel('ventas')->info('Venta creada', [
            'venta_id'   => $venta->id,
            'producto_id'=> $venta->producto_id,
            'cliente_id' => $venta->cliente_id,
            'vendedor_id'=> Auth::id(),
            'total'      => $venta->total,
        ]);

        return redirect()->route('ventas.index')
                         ->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta)
    {
        $this->authorize('viewAny', Venta::class);
        $venta->load(['producto', 'cliente', 'vendedor']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $this->authorize('update', $venta);
        $productos = Producto::all();
        $clientes  = Usuario::where('rol', 'cliente')->get();
        return view('ventas.edit', compact('venta', 'productos', 'clientes'));
    }

    public function update(StoreVentaRequest $request, Venta $venta)
    {
        $this->authorize('update', $venta);
        $venta->update($request->validated());
        return redirect()->route('ventas.index')
                         ->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Venta $venta)
    {
        $this->authorize('delete', $venta);
        $venta->delete();
        return redirect()->route('ventas.index')
                         ->with('success', 'Venta eliminada correctamente.');
    }
}