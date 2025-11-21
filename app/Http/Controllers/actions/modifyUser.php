<?php
use PHPMailer\PHPMailer\PHPMailer;

$id = $_POST["floating_id"];
$first_name = $_POST["floating_first_name"];
$last_name = $_POST["floating_last_name"];
$birth_date = $_POST["date"];
$phone_number = $_POST["floating_phone"];
$profile_photo = $_FILES["photo"];
$password_raw = $_POST["floating_password"];
$password_raw_2 = $_POST["floating_repeat_password"];
$user_type = $_POST["user_type"];

if (!$first_name || !$last_name || !$birth_date || !$phone_number || !$user_type || !$password_raw || !$password_raw_2) {
    exit('Missing required fields');
}
if ($password_raw !== $password_raw_2) {
    exit('Passwords do not match');
}

$password = password_hash($password_raw, PASSWORD_BCRYPT);

// 1) Subir foto
$photo_rel = handleProfileUpload($_FILES['photo'] ?? null);

$result = updateProfile(
    $id,
    $first_name,
    $last_name,
    $password,
    $phone_number,
    $birth_date,
    $photo_rel,
    $user_type,
);

if ($result !== true) {
    echo "Error: $result";
    exit();
}

echo '<form id="logoutForm" action="/post/logout.php" method="POST"></form>
<script>document.getElementById("logoutForm").submit();</script>';
exit();

exit();


?>