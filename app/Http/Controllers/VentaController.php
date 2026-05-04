<?php

namespace App\Http\Controllers;

use App\Mail\VentaValidadaCompradorMail;
use App\Mail\VentaValidadaVendedorMail;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Usuario;
use App\Http\Requests\StoreVentaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

        $ticketPath = null;
        if ($request->hasFile('ticket')) {
            // Disco privado: no accesible vía URL pública
            $ticketPath = $request->file('ticket')->store('tickets', 'local');
        }

        $venta = Venta::create([
            ...$request->safe()->except('ticket'),
            'vendedor_id' => Auth::id(),
            'ticket'      => $ticketPath,
        ]);

        Log::channel('ventas')->info('Venta creada', [
            'venta_id'    => $venta->id,
            'producto_id' => $venta->producto_id,
            'cliente_id'  => $venta->cliente_id,
            'vendedor_id' => Auth::id(),
            'total'       => $venta->total,
        ]);

        return redirect()->route('ventas.index')
                         ->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta)
    {
        $this->authorize('view', $venta);
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

        $ticketPath = $venta->ticket;
        if ($request->hasFile('ticket')) {
            // Eliminar ticket anterior del disco privado
            if ($ticketPath) {
                Storage::disk('local')->delete($ticketPath);
            }
            $ticketPath = $request->file('ticket')->store('tickets', 'local');
        }

        $venta->update([
            ...$request->safe()->except('ticket'),
            'ticket' => $ticketPath,
        ]);

        return redirect()->route('ventas.index')
                         ->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Venta $venta)
    {
        $this->authorize('delete', $venta);

        if ($venta->ticket) {
            Storage::disk('local')->delete($venta->ticket);
        }

        $venta->delete();

        return redirect()->route('ventas.index')
                         ->with('success', 'Venta eliminada correctamente.');
    }

    // Servir ticket desde disco privado (solo dueño de la venta o gerente)
    public function verTicket(Venta $venta)
    {
        $this->authorize('verTicket', $venta);

        if (!$venta->ticket || !Storage::disk('local')->exists($venta->ticket)) {
            abort(404, 'Ticket no encontrado.');
        }

        return response()->file(Storage::disk('local')->path($venta->ticket));
    }

    // Validar venta (solo gerente) y enviar correos de notificación
    public function validar(Venta $venta)
    {
        $this->authorize('validar', $venta);

        $venta->update(['validada' => true]);
        $venta->load(['producto', 'cliente', 'vendedor']);

        Mail::to($venta->vendedor->correo)->send(new VentaValidadaVendedorMail($venta));
        Mail::to($venta->cliente->correo)->send(new VentaValidadaCompradorMail($venta));

        Log::channel('ventas')->info('Venta validada', [
            'venta_id'    => $venta->id,
            'gerente_id'  => Auth::id(),
        ]);

        return redirect()->route('ventas.index')
                         ->with('success', 'Venta validada y notificaciones enviadas.');
    }
}