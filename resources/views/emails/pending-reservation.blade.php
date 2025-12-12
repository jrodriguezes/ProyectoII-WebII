<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reserva pendiente</title>
</head>

<body>

    <h2>Hola {{ $driver->first_name }}</h2>

    <p>
        Tenés una reserva pendiente desde hace
        <strong>{{ $reservation->created_at->diffInMinutes(now()) }}</strong> minutos.
    </p>

    <h3>Viaje</h3>
    <ul>
        <li><strong>Nombre:</strong> {{ $reservation->ride->name }}</li>
        <li><strong>Origen:</strong> {{ $reservation->ride->origin }}</li>
        <li><strong>Destino:</strong> {{ $reservation->ride->destination }}</li>
    </ul>

    <h3>Pasajero</h3>
    <p>{{ $passenger->first_name }}</p>

    <p>
        Ingresá a la app para aceptar o rechazar la reserva.
    </p>

</body>

</html>