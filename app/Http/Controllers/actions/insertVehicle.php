<?php
require_once __DIR__ . '/../../config/session.php';

$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['id'])) {
    http_response_code(401);
    exit('Unauthorized');
}

$plate_id = $_POST["plate_id"];
$color = $_POST["color"];
$brand = $_POST["brand"];
$model = $_POST["model"];
$year = $_POST["year"];
$seats = $_POST["seats"];
$driverId = $user['id'];

if (!$plate_id || !$color || !$brand || !$model || !$year || !$seats || !$driverId) {
    exit('Missing required fields');
}
$rel_vehicle_picture = handleProfileUpload($_FILES["vehicle-picture"]);

$result = insertVehicle(
    $plate_id,
    $color,
    $brand,
    $model,
    $year,
    $seats,
    $rel_vehicle_picture,
    $driverId
);

if ($result !== true) {
    echo "Error: $result";
    exit();
}
header("Location: /home");
exit();
?>