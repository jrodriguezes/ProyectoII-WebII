<?php
require_once __DIR__ . "/../config/db.php";
function findUserByEmail(string $email)
{
    $conn = getConnection();

    $sql = "SELECT * FROM USERS WHERE EMAIL = '$email'";

    $result = $conn->query($sql);

    if ($result) {
        $user = $result->fetch_assoc();
        $conn->close();
        return $user;
    } else {
        $conn->close();
        return null;
    }

}
?>