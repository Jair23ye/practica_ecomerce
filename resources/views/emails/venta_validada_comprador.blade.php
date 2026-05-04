<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:500px; margin:40px auto; background:#fff; border-radius:8px; padding:40px; }
        .badge { display:inline-block; background:#dbeafe; color:#1d4ed8; padding:6px 14px;
                 border-radius:20px; font-weight:bold; margin-bottom:16px; }
        table { width:100%; border-collapse:collapse; margin:20px 0; }
        td { padding:10px; border-bottom:1px solid #e5e7eb; }
        td:first-child { color:#6b7280; }
        .contact-box { background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px;
                       padding:16px; margin-top:20px; }
    </style>
</head>
<body>
    <div class="container">
        <span class="badge">✓ Compra Validada</span>
        <h2>¡Tu compra ha sido validada!</h2>
        <p>Hola <strong>{{ $venta->cliente->nombre }}</strong>, tu compra ha sido confirmada:</p>

        <table>
            <tr><td>Producto</td><td><strong>{{ $venta->producto->nombre }}</strong></td></tr>
            <tr><td>Total pagado</td><td><strong>${{ number_format($venta->total, 2) }}</strong></td></tr>
            <tr><td>Fecha</td><td>{{ $venta->fecha }}</td></tr>
        </table>

        <div class="contact-box">
            <strong>¿Tienes dudas sobre tu pedido?</strong><br>
            Contacta directamente al vendedor: <strong>{{ $venta->vendedor->correo }}</strong>
        </div>
    </div>
</body>
</html>