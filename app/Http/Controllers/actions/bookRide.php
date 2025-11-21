<?php
$id = random_int(1, 9999999);
$ride_id = $_POST['ride_id'];
$passenger_id = $_POST['user_id'];
$status = 'pending';

$result = bookRide(
    $id,
    $ride_id,
    $passenger_id,
    $status,
);

if ($result !== true) {
    echo "Error: $result";
    exit();
}

$result2 = updateSeat(
    $ride_id
);

if ($result2 != true) {
    echo "Error: $result";
    exit();
}

header("Location: /booking");
exit();

?>