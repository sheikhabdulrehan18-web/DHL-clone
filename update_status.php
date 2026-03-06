<?php
session_start();
require_once 'db.php';
 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}
 
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}
 
$pkg_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->execute([$pkg_id]);
$package = $stmt->fetch();
 
if (!$package) {
    die("Package not found.");
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_status = $_POST['status'];
    $location = $_POST['location'];
    $notes = $_POST['notes'];
 
    // Update main status
    $u_stmt = $pdo->prepare("UPDATE packages SET status = ? WHERE id = ?");
    $u_stmt->execute([$new_status, $pkg_id]);
 
    // Add history
    $h_stmt = $pdo->prepare("INSERT INTO tracking_history (package_id, location, status_update, notes) VALUES (?, ?, ?, ?)");
    $h_stmt->execute([$pkg_id, $location, $new_status, $notes]);
 
    header("Location: admin.php?msg=Status updated successfully!");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Status | Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
 
    <div class="container">
        <header>
            <div class="logo">DHL<span>ADMIN</span></div>
            <nav>
                <a href="admin.php">Back to Dashboard</a>
            </nav>
        </header>
 
        <div class="auth-box glass" style="margin-top:50px; max-width: 600px;">
            <h2>Update Status: <?php echo $package['tracking_id']; ?></h2>
            <form method="POST">
                <div class="form-group">
                    <label>New Status</label>
                    <select name="status" class="input-field" style="width:100%; background: #222;">
                        <option value="Pending" <?php echo $package['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="In Transit" <?php echo $package['status'] == 'In Transit' ? 'selected' : ''; ?>>In Transit</option>
                        <option value="Out for Delivery" <?php echo $package['status'] == 'Out for Delivery' ? 'selected' : ''; ?>>Out for Delivery</option>
                        <option value="Delivered" <?php echo $package['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                        <option value="Cancelled" <?php echo $package['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Current Location</label>
                    <input type="text" name="location" class="input-field" placeholder="e.g. London Distribution Center" required style="width:100%;">
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <textarea name="notes" class="input-field" style="width:100%; height: 100px; border-radius: 15px;"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Update & Add to History</button>
            </form>
        </div>
    </div>
 
    <script src="script.js"></script>
</body>
</html>
 
