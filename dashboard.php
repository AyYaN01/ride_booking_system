<?php
session_start();
include 'db.php';

$user = $_SESSION['user'] ?? null;
if (!$user) {
    header("Location: index.php");
    exit();
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<div class="container mt-5">
    <div class="text-center mb-4">
        <h2>Welcome, <?= ucfirst($user['type']) ?> <?= $user['name'] ?></h2>
    </div>

    <?php if ($user['type'] === 'passenger'): ?>
        <div class="card mb-4">
            <div class="card-header">Book a Ride</div>
            <div class="card-body">
                <form action="ride_request.php" method="POST">
                    <div class="mb-3">
                        <input name="pickup" class="form-control" placeholder="Pickup Location" required>
                    </div>
                    <div class="mb-3">
                        <input name="dropoff" class="form-control" placeholder="Drop-off Location" required>
                    </div>
                    <div class="mb-3">
                        <select name="ride_type" class="form-select">
                            <option value="Bike">Bike</option>
                            <option value="Car">Car</option>
                            <option value="Rickshaw">Rickshaw</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Request Ride</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Your Ride History</div>
            <ul class="list-group list-group-flush">
                <?php
                $pid = $user['id'];
                $rides = $db->query("SELECT * FROM rides WHERE passenger_id = $pid");
                while ($r = $rides->fetchArray()) {
                    echo "<li class='list-group-item'><strong>{$r['pickup']} → {$r['dropoff']}</strong> ({$r['ride_type']}) - <span class='badge bg-primary'>{$r['status']}</span></li>";
                }
                ?>
            </ul>
        </div>

    <?php else: ?>
        <div class="card">
            <div class="card-header">Available Ride Requests</div>
            <div class="card-body">
                <?php
                $rides = $db->query("SELECT * FROM rides WHERE status = 'Requested'");
                while ($r = $rides->fetchArray()) {
                    echo "<form action='update_status.php' method='POST' class='mb-3 p-3 border rounded'>
                        <p><strong>{$r['pickup']} → {$r['dropoff']}</strong> ({$r['ride_type']})</p>
                        <input type='hidden' name='ride_id' value='{$r['id']}'>
                        <div class='d-flex gap-2'>
                            <button name='action' value='accept' class='btn btn-primary'>Accept</button>
                            <button name='action' value='reject' class='btn btn-outline-danger'>Reject</button>
                        </div>
                    </form>";
                }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</div>