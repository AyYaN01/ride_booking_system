<?php
$db = new SQLite3('ride_booking.db');
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    password TEXT,
    type TEXT
)");
$db->exec("CREATE TABLE IF NOT EXISTS rides (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    passenger_id INTEGER,
    driver_id INTEGER,
    pickup TEXT,
    dropoff TEXT,
    ride_type TEXT,
    status TEXT
)");
?>