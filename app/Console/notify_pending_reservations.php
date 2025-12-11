<?php
require_once __DIR__ . '/../models/ReservationModel.php';

require_once __DIR__ . '/../services/EmailService.php';

$minutes = $argv[1] ?? 15;
$minutes = (int) $minutes;

$result = getPendingReservationsOlderThan($minutes);

if (empty($result)) {
    echo 'no hay resuldatos de la base de datos';
}

foreach ($result as $reservation) {

    $createdTime = new DateTime($reservation['created_at']);
    $now = new DateTime(); // Fecha actual

    // Diferencia
    $interval = $createdTime->diff($now);

    // Convertir la diferencia a minutos totales
    $minutesPassed = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

    echo 'El driver : ' . $reservation['driver_name'] . ' Email : ' . $reservation['driver_email'] .
        ' (ID : ' . $reservation['driver_id'] . ' ) ' . PHP_EOL.'(ID ride '. $reservation['reservation_id'] . ')'
        . ' En el ride de nombre ' . $reservation['ride_name'] 
        . ' Con una diferencia ' . $minutesPassed . ' en minutos desde la creacion hasta este momento' . PHP_EOL;

    try {
        sendReservationNotificationEmail(
            $reservation['driver_email'],            // a quién le mando
            $reservation['driver_name'],             // nombre del chofer
            $reservation['driver_user_id'],          // id del chofer
            $reservation['ride_name'],               // nombre del ride
            $reservation['ride_id'],                 // id del ride
            $reservation['origin'],                  // origen
            $reservation['destination'],             // destino
            $reservation['passenger_id'],            // id pasajero
            $reservation['passenger_name']           // nombre pasajero
        );
    } catch (Throwable $e) {
        error_log('Mailer error: ' . $e->getMessage());
    }
}

?>