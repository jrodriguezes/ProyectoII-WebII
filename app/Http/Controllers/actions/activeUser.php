<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../models/UserModel.php';

$user_id = $_POST['user_id'];

$result = activeUser($user_id);
if ($result) {
    header("Location: /home");
    exit();
} else {
    echo "Error: $result";
    exit();
}
?>