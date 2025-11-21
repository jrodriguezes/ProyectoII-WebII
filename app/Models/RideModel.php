<?php
require_once __DIR__ . '/../config/db.php';

function insertRide($driver_id, $vehicle_plate, $name, $origin, $destination, $departure_date, $price_per_seat, $seats_offered)
{
    $conn = getConnection();

    $sql = "INSERT INTO rides (driver_id, vehicle_plate, name, origin, destination, departure_date, price_per_seat, seats_offered)
            VALUES ('$driver_id', '$vehicle_plate', '$name', '$origin', '$destination', '$departure_date', '$price_per_seat', '$seats_offered')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $error = 'Error: ' . $conn->error;
        $conn->close();
        return $error;
    }
}

function updateRide($ride_id, $name, $origin, $destination, $departure_date, $price_per_seat, $seats_offered)
{
    $conn = getConnection();

    $sql = "UPDATE rides SET 
                name = '$name',
                origin = '$origin',
                destination = '$destination',
                departure_date = '$departure_date',
                price_per_seat = '$price_per_seat',
                seats_offered = '$seats_offered'
            WHERE id = '$ride_id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return 'Error: ' . $conn->error;
    }

    $conn->close();
}

function deleteRide($ride_id, $driver_id)
{
    $conn = getConnection();

    $sql = "UPDATE rides set status = 'cancelled' where id = '$ride_id' AND driver_id = '$driver_id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

    $conn->close();
}

function getRidesByDriver($driverId)
{

    $conn = getConnection();

    $sql = "SELECT id, driver_id, vehicle_plate, name, origin, destination, departure_date, price_per_seat, seats_offered
                FROM rides
                WHERE driver_id = '$driverId' and status = 'active'";

    $result = $conn->query($sql);

    $rides = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rides[] = $row;
        }
    }

    $conn->close();
    return $rides;
}
function getAllRides()
{
    $conn = getConnection();

    $sql = "
        SELECT
            r.id,
            r.driver_id,
            r.name               AS ride_name,
            r.origin,
            r.destination,
            r.departure_date,
            r.price_per_seat,
            r.seats_offered,
            r.status             AS ride_status,

            -- Conductor
            u.id                 AS driver_id,
            u.first_name,
            u.last_name,
            u.email,
            u.phone_number,
            u.profile_photo,

            -- Vehículo
            v.plate_id,
            v.brand,
            v.model,
            v.year,
            v.color,
            v.seats              AS vehicle_seats,
            v.vehicle_picture

        FROM rides AS r
        INNER JOIN users AS u
            ON r.driver_id = u.id
        LEFT JOIN vehicles AS v
            ON r.vehicle_plate = v.plate_id
        WHERE r.status = 'active'
        ORDER BY r.departure_date DESC  -- 👈 del más reciente al más antiguo
    ";

    $result = $conn->query($sql);

    $rides = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rides[] = $row;
        }
    }

    $conn->close();
    return $rides;
}


function bookRide($id, $ride_id, $passenger_id, $status)
{
    $conn = getConnection();

    $sql = "INSERT INTO reservations (id, ride_id, passenger_id, status, created_at, updated_at)
            VALUES ('$id','$ride_id', '$passenger_id', '$status', NOW(), NOW())";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $error = 'Error: ' . $conn->error;
        $conn->close();
        return $error;
    }
}

function updateSeat($id)
{
    $conn = getConnection();

    $sql = "Update rides set seats_offered = seats_offered -1 where id = '$id'";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $error = 'Error: ' . $conn->error;
        $conn->close();
        return $error;
    }
}
?>