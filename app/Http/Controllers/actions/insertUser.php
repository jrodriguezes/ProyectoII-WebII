<?php
use PHPMailer\PHPMailer\PHPMailer;

$id = $_POST["floating_id"];
$first_name = $_POST["floating_first_name"];
$last_name = $_POST["floating_last_name"];
$birth_date = $_POST["date"];
$email = $_POST["floating_email"];
$phone_number = $_POST["floating_phone"];
$profile_photo = $_FILES["photo"];
$password_raw = $_POST["floating_password"];
$password_raw_2 = $_POST["floating_repeat_password"];
$user_type = $_POST["user_type"];
$stateId = "pending";

if (!$id || !$first_name || !$last_name || !$birth_date || !$email || !$phone_number || !$user_type || !$password_raw || !$password_raw_2) {
    exit('Missing required fields');
}
if ($password_raw !== $password_raw_2) {
    exit('Passwords do not match');
}

$password = password_hash($password_raw, PASSWORD_BCRYPT);

// 1) Subir foto
$photo_rel = handleProfileUpload($_FILES['photo'] ?? null);

// 2) Token de verificación
[$token, $verify_hash, $verify_expires] = generateVerification();

$result = insertUser(
    $id,
    $first_name,
    $last_name,
    $birth_date,
    $email,
    $phone_number,
    $photo_rel,
    $password,
    $user_type,
    $stateId,
    $verify_hash,
    $verify_expires
);

if ($result !== true) {
    echo "Error: $result";
    exit();
}

// 4) URL y envío de email (servicio)
$verifyUrl = "http://www.proyecto01webii.net:8080/verify-email?uid={$id}&token={$token}";
try {
    sendVerificationEmail($email, "$first_name $last_name", verifyUrl: $verifyUrl);
} catch (Throwable $e) {
    error_log('Mailer error: ' . $e->getMessage());
}


header("Location: /check-your-email");
exit();


?>