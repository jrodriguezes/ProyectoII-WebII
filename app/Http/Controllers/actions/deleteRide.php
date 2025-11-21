<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../models/RideModel.php';


$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['id'])) {
   http_response_code(401);
    exit('Unauthorized');
}

$ride_id = $_POST['ride_id'];

$result = deleteRide($ride_id, $user['id']);
if ($result) {
    header("Location: /home");
    exit();
} else {
    echo "Error: $result";
    exit();
}

?>