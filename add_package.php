<?php
session_start();
require_once 'db.php';
 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tracking_id = "DHL" . rand(100000, 999999);
    $sender = $_POST['sender_name'];
    $receiver = $_POST['receiver_name'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $weight = $_POST['weight'];
    $user_id = $_SESSION['user_id'];
 
    $stmt = $pdo->prepare("INSERT INTO packages (tracking_id, sender_name, receiver_name, origin, destination, weight, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$tracking_id, $sender, $receiver, $origin, $destination, $weight, $user_id]);
 
    // Initial history
    $pkg_id = $pdo->lastInsertId();
    $stmt_hist = $pdo->prepare("INSERT INTO tracking_history (package_id, location, status_update, notes) VALUES (?, ?, 'Package Registered', 'Shipment information received')");
    $stmt_hist->execute([$pkg_id, $origin]);
 
    header("Location: dashboard.php?msg=Package added! ID: $tracking_id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ship New Package | DHL Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
 
    <div class="container">
        <header>
            <div class="logo">DHL<span>CLONE</span></div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>
 
        <div class="auth-box glass" style="margin-top:50px; max-width: 600px;">
            <h2>Ship New Package</h2>
            <form method="POST">
                <div class="grid" style="grid-template-columns: 1fr 1fr; margin-top:0;">
                    <div class="form-group">
                        <label>Sender Name</label>
                        <input type="text" name="sender_name" class="input-field" required style="width:100%;">
                    </div>
                    <div class="form-group">
                        <label>Receiver Name</label>
                        <input type="text" name="receiver_name" class="input-field" required style="width:100%;">
                    </div>
                    <div class="form-group">
                        <label>Origin</label>
                        <input type="text" name="origin" class="input-field" required style="width:100%;">
                    </div>
                    <div class="form-group">
                        <label>Destination</label>
                        <input type="text" name="destination" class="input-field" required style="width:100%;">
                    </div>
                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" step="0.01" name="weight" class="input-field" required style="width:100%;">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; margin-top:20px;">Create Shipment</button>
            </form>
        </div>
    </div>
 
    <script src="script.js"></script>
</body>
</html>
 
