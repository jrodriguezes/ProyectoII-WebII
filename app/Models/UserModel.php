<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . "/../services/UploadService.php";

function insertUser($id, $first_name, $last_name, $birth_date, $email, $phone_number, $profile_photo, $password, $user_type, $stateId, $verify_hash, $verify_expires)
{
    $conn = getConnection();

    $sql = "INSERT INTO users (id, first_name, last_name, birth_date, email, phone_number, profile_photo, password, user_type, status, verify_token_hash, verify_token_expires_at)
            VALUES ('$id', '$first_name', '$last_name', '$birth_date', '$email', '$phone_number', '$profile_photo', '$password', '$user_type', '$stateId', '$verify_hash', '$verify_expires')";

    if ($conn->query($sql) == TRUE) {
        return true;
    } else {
        return 'Error: ' . $conn->error;
    }

    $conn->close();
}

function updateProfile($user_id, $first_name, $last_name, $password, $phone_number, $birth_date, $photo, $user_type)
{
    $conn = getConnection();

    $sql = "UPDATE users SET 
                first_name = '$first_name',
                last_name = '$last_name',
                password = '$password',
                phone_number = '$phone_number',
                birth_date = '$birth_date',
                profile_photo = '$photo',
                user_type = '$user_type'
            WHERE id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return 'Error: ' . $conn->error;
    }

    $conn->close();
}

require_once __DIR__ .'/../config/db.php';

function getUsers() {
    $conn = getConnection();

    $sql = "SELECT 
                id,
                first_name,
                last_name,
                birth_date,
                email,
                phone_number,
                profile_photo,
                user_type,
                status,
                created_at
            FROM users";

    $result = $conn->query($sql);

    $users = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    $conn->close();

    return $users;
}

function deleteUser ($id) {
    $conn = getConnection();

    $sql = "UPDATE users 
                set status = 'inactive'
                where id = $id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return 'Error: ' . $conn->error;
    }

    $conn->close();            
}

function activeUser ($id) {
    $conn = getConnection();

    $sql = "UPDATE users 
                set status = 'active'
                where id = $id";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return 'Error: ' . $conn->error;
    }

    $conn->close();            
}


?>