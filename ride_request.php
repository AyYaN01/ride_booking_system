<?php
session_start();
include 'db.php';

$pickup = $_POST['pickup'];
$dropoff = $_POST['dropoff'];
$ride_type = $_POST['ride_type'];
$passenger_id = $_SESSION['user']['id'];

$db->exec("INSERT INTO rides (passenger_id, pickup, dropoff, ride_type, status)
           VALUES ($passenger_id, '$pickup', '$dropoff', '$ride_type', 'Requested')");

header("Location: dashboard.php");
