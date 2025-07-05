<?php
session_start();
include 'db.php';

$ride_id = $_POST['ride_id'];
$action = $_POST['action'];

if ($action == 'accept') {
    $driver_id = $_SESSION['user']['id'];
    $db->exec("UPDATE rides SET status = 'Accepted', driver_id = $driver_id WHERE id = $ride_id");
} else {
    $db->exec("UPDATE rides SET status = 'Rejected' WHERE id = $ride_id");
}

header("Location: dashboard.php");
