<?php
require_once __DIR__ . '/../config/db.php';

function insertVehicle($plate_id, $color, $brand, $model, $year, $seats, $vehicle_picture, $driver_id)
{
    $conn = getConnection();

    $sql = "INSERT INTO vehicles (plate_id, driver_id, color, brand, model, year, seats, vehicle_picture)
            VALUES ('$plate_id', '$driver_id', '$color', '$brand', '$model', '$year', '$seats', '$vehicle_picture')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return 'Error: ' . $conn->error;
    }

    $conn->close();
}

function modifyVehicle($plate_id, $color, $brand, $model, $year, $seats, $vehicle_picture, $driver_id)
{
    $conn = getConnection();

    $sql = "UPDATE vehicles SET 
                color = '$color',
                brand = '$brand',
                model = '$model',
                year = '$year',
                seats = '$seats'";

    if (!empty($vehicle_picture)) {
        $sql .= ", vehicle_picture = '$vehicle_picture'";
    }

    $sql .= " WHERE plate_id = '$plate_id' AND driver_id = '$driver_id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return 'Error: ' . $conn->error;
    }

    $conn->close();
}

function deleteVehicle($plate_id, $driver_id)
{
    $conn = getConnection();

    $sql = "UPDATE vehicles set status = 'inactive' where plate_id = '$plate_id' and driver_id = '$driver_id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

    $conn->close();
}

function getVehicles($userId)
{

    $conn = getConnection();

    $sql = "SELECT plate_id, driver_id, color, brand, model, year, seats, vehicle_picture
                FROM vehicles
                WHERE driver_id = '$userId' and status = 'active'";


    $result = $conn->query($sql);

    $vehicles = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
    }

    $conn->close();
    return $vehicles;
}
?>