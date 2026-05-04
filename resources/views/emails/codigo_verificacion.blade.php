<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
        .container { max-width:500px; margin:40px auto; background:#fff; border-radius:8px; padding:40px; }
        .codigo { font-size:36px; font-weight:bold; letter-spacing:8px; color:#1d4ed8;
                  text-align:center; background:#eff6ff; padding:20px; border-radius:8px; margin:24px 0; }
        .footer { font-size:12px; color:#9ca3af; margin-top:24px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hola, {{ $nombre }}</h2>
        <p>Ingresa el siguiente código para completar tu inicio de sesión. Expira en <strong>5 minutos</strong>.</p>

        <div class="codigo">{{ $codigo }}</div>

        <p>Si no solicitaste este código, ignora este mensaje.</p>
        <div class="footer">Este correo fue generado automáticamente, no respondas.</div>
    </div>
</body>
</html>