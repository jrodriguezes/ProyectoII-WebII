<?php

$ride_id = (int) $_POST['ride_id'];
$name = $_POST['name'];
$vehicle_plate = $_POST['vehicle_id'];
$origin = $_POST['origin'];
$destination = $_POST['destination'];
// reconstruir days según tus checkboxes individuales:


$departure_date = $_POST['departure_date'];     
$price_per_seat = (float) $_POST['price_per_seat'];
$seats_offered = (int) $_POST['seats_offered'];


$result = updateRide(
    $ride_id,
    $name,
    $origin,
    $destination,
    $departure_date,
    $price_per_seat,
    $seats_offered
);

if ($result !== true) {
    echo "Error: $result";
    exit();
}
header("Location: /home");
exit();


?>