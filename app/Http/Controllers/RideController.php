<?php
require_once __DIR__ . "/../models/RideModel.php";
require_once __DIR__ . "/../services/UploadService.php";
$action = $_POST["action"] ?? null;

switch ($action) {

    case "register_ride":
        include __DIR__ . "/actions/insertRide.php";
        break;

    case "modify_ride";
        include __DIR__ . "/actions/modifyRide.php";
        break;

    case "delete_ride":
        include __DIR__ . "/actions/deleteRide.php";
        break;

    case "book_ride":
        include __DIR__ . "/actions/bookRide.php";
        break;

    default:
        http_response_code(400);
        exit("Unknown insert action");
}
?>