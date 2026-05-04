<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:500px; margin:40px auto; background:#fff; border-radius:8px; padding:40px; }
        .badge { display:inline-block; background:#dcfce7; color:#16a34a; padding:6px 14px;
                 border-radius:20px; font-weight:bold; margin-bottom:16px; }
        table { width:100%; border-collapse:collapse; margin:20px 0; }
        td { padding:10px; border-bottom:1px solid #e5e7eb; }
        td:first-child { color:#6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <span class="badge">✓ Venta Validada</span>
        <h2>¡Tu venta ha sido validada!</h2>
        <p>Hola <strong>{{ $venta->vendedor->nombre }}</strong>, el gerente ha validado la siguiente venta:</p>

        <table>
            <tr><td>Producto</td><td><strong>{{ $venta->producto->nombre }}</strong></td></tr>
            <tr><td>Total</td><td><strong>${{ number_format($venta->total, 2) }}</strong></td></tr>
            <tr><td>Fecha</td><td>{{ $venta->fecha }}</td></tr>
            <tr><td>Comprador</td><td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</td></tr>
            <tr><td>Correo del comprador</td><td>{{ $venta->cliente->correo }}</td></tr>
        </table>

        <p>Comunícate con el comprador para coordinar la entrega.</p>
    </div>
</body>
</html>