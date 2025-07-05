<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $type = $_POST['type'];

    $result = $db->query("SELECT * FROM users WHERE name='$name' AND password='$password'");
    $user = $result->fetchArray();

    if ($user) {
        $_SESSION['user'] = $user;
    } else {
        $db->exec("INSERT INTO users (name, password, type) VALUES ('$name', '$password', '$type')");
        $id = $db->lastInsertRowID();
        $_SESSION['user'] = ['id' => $id, 'name' => $name, 'type' => $type];
    }

    header('Location: dashboard.php');
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<div class="container">
    <h2>Ride Booking Login/Register</h2>
    <form method="POST">
        <div class="mb-3">
            <input class="form-control" name="name" placeholder="Your Name" required>
        </div>
        <div class="mb-3">
            <input class="form-control" name="password" placeholder="Password" type="password" required>
        </div>
        <div class="mb-3">
            <select class="form-select" name="type">
                <option value="passenger">Passenger</option>
                <option value="driver">Driver</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Continue</button>
    </form>
</div>
