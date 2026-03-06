<?php
session_start();
require_once 'db.php';
 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
 
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM packages WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$packages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | DHL Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
 
    <div class="container">
        <header>
            <div class="logo">DHL<span>CLONE</span></div>
            <nav>
                <a href="index.php">Home</a>
                <a href="add_package.php">Ship Package</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>
 
        <h2 style="margin-top:40px;">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
 
        <div class="glass card" style="margin-top:20px;">
            <h3>Your Shipments</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tracking ID</th>
                        <th>Receiver</th>
                        <th>Destination</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($packages)): ?>
                        <tr><td colspan="5" style="text-align:center;">No packages found.</td></tr>
                    <?php else: ?>
                        <?php foreach($packages as $pkg): ?>
                        <tr>
                            <td><strong><?php echo $pkg['tracking_id']; ?></strong></td>
                            <td><?php echo htmlspecialchars($pkg['receiver_name']); ?></td>
                            <td><?php echo htmlspecialchars($pkg['destination']); ?></td>
                            <td><span class="status-badge status-<?php echo str_replace(' ', '-', $pkg['status']); ?>"><?php echo $pkg['status']; ?></span></td>
                            <td><a href="track.php?id=<?php echo $pkg['tracking_id']; ?>" class="btn btn-primary" style="padding: 5px 15px; font-size: 0.8rem;">Track</a></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
 
    <script src="script.js"></script>
</body>
</html>
 
