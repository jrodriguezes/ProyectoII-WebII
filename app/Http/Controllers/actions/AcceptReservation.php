<?php

$reservation_id = $_POST['reservation_id'];

$result = acceptResevations($reservation_id);

if ($result !== true) {
    echo "Error: $result";
    exit();
}
header("Location: /booking");
exit();

?>