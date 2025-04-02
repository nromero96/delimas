<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reclamación Recibida</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #333; }
        p { font-size: 14px; color: #666; }
        .reclamacion { background: #f9f9f9; padding: 10px; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Reclamación Recibida</h1>
    <p>Estimado/a,</p>
    <p>Hemos recibido una nueva reclamación a través de nuestro libro de reclamaciones. A continuación, los detalles de la misma:</p>

    <div class="reclamacion">
        <p><strong>Nombre:</strong> {{ $reclamo['name'] }}</p>
        <p><strong>DNI:</strong> {{ $reclamo['dni'] }}</p>
        <p><strong>Correo Electrónico:</strong> {{ $reclamo['email'] }}</p>
        <p><strong>Teléfono:</strong> {{ $reclamo['phone'] }}</p>
        <p><strong>Fecha del Reclamo:</strong> {{ $reclamo['date'] }}</p>
        <p><strong>Descripción del Reclamo:</strong><br>{{ $reclamo['description'] }}</p>
        <p><strong>Solicitud de Solución:</strong><br>{{ $reclamo['solution'] }}</p>
    </div>

    <p>Nos pondremos en contacto con usted a la mayor brevedad posible para dar seguimiento a su caso.</p>

    <p>Atentamente,<br>El equipo de atención al cliente</p>
</body>
</html>
