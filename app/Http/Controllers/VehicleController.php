<?php
require_once __DIR__ . "/../models/VehicleModel.php";
require_once __DIR__ . "/../services/UploadService.php";

$action = $_POST["action"] ?? null;

switch ($action) {
    case "register_vehicle":
        include __DIR__ . "/actions/insertVehicle.php";
        break;

    case "modify_vehicle":
        include __DIR__ . "/actions/modifyVehicle.php";
        break;

    case "delete_vehicle":
        include __DIR__ . "/actions/deleteVehicle.php";
        break;

    default:
        http_response_code(400);
        exit("Unknown insert action");
}
?>