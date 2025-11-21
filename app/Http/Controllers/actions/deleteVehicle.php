<?php
require_once __DIR__ . '/../../config/session.php';

$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['id'])) {
    http_response_code(401);
    exit('Unauthorized');
}

$plate_id = $_POST['plate_id'];

$result = deleteVehicle($plate_id, $user['id']);

if ($result !== true) {
    echo "Error: $result";
    exit();
}
header("Location: /home");
exit();


?>