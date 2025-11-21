<?php
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../config/mailer.php";

require_once __DIR__ . "/../services/UploadService.php";
require_once __DIR__ . "/../services/VerificationService.php";
require_once __DIR__ . "/../services/EmailService.php";
$action = $_POST["action"] ?? null;

switch ($action) {
    case "register_user":
        include __DIR__ . "/actions/insertUser.php";
        break;

    case "modify_user";
        include __DIR__ . "/actions/modifyUser.php";
        break;
    case "delete_user"; 
        include __DIR__ . "/actions/deleteUser.php";
        break;
    case "active_user";
        include __DIR__ . "/actions/activeUser.php";
        break;
    default:
        http_response_code(400);
        exit("Unknown insert action");
}
?>