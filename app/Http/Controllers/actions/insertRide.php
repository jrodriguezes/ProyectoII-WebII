<?php
require_once __DIR__ . '/../../config/session.php';

$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['id'])) {
    http_response_code(401);
    exit('Unauthorized');
}


$driverId = $user['id'];
$vehicleId = $_POST["vehicle_id"];
$name = $_POST["name"];
$deputure = $_POST["departure"];
$arrival = $_POST["arrival"];

// Collect selected days

// end collect selected days

$departure_date = $_POST["departure_date"];
$price_per_seat = $_POST["price_seats"];
$seats_offered = $_POST["seats"];

if (
    !$driverId || !$vehicleId || !$name || !$deputure || !$arrival || !$departure_date || !$price_per_seat || !$seats_offered
) {
    exit('Missing required fields');
}

$result = insertRide(
    $driverId,
    $vehicleId,
    $name,
    $deputure,
    $arrival,
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

