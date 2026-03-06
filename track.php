<?php
session_start();
require_once 'db.php';
 
$package = null;
$history = [];
if (isset($_GET['id'])) {
    $tid = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE tracking_id = ?");
    $stmt->execute([$tid]);
    $package = $stmt->fetch();
 
    if ($package) {
        $hstmt = $pdo->prepare("SELECT * FROM tracking_history WHERE package_id = ? ORDER BY created_at DESC");
        $hstmt->execute([$package['id']]);
        $history = $hstmt->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Shipment | DHL Clone</title>
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
                <a href="login.php">Login</a>
            </nav>
        </header>
 
        <section class="hero" style="height: auto; padding: 100px 0 50px;">
            <h1>Track Shipment</h1>
            <form action="track.php" method="GET" class="track-form glass">
                <input type="text" name="id" class="input-field" placeholder="Enter Tracking ID" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" required>
                <button type="submit" class="btn btn-primary">Track</button>
            </form>
        </section>
 
        <?php if(isset($_GET['id']) && !$package): ?>
            <div class="glass card" style="text-align:center; color: var(--dhl-red);">
                <h3>No shipment found with ID: <?php echo htmlspecialchars($_GET['id']); ?></h3>
            </div>
        <?php elseif($package): ?>
            <div class="grid">
                <div class="glass card">
                    <h3>Shipment Details</h3>
                    <p><strong>Tracking ID:</strong> <?php echo $package['tracking_id']; ?></p>
                    <p><strong>Status:</strong> <span class="status-badge status-<?php echo str_replace(' ', '-', $package['status']); ?>"><?php echo $package['status']; ?></span></p>
                    <p><strong>From:</strong> <?php echo htmlspecialchars($package['origin']); ?> (<?php echo htmlspecialchars($package['sender_name']); ?>)</p>
                    <p><strong>To:</strong> <?php echo htmlspecialchars($package['destination']); ?> (<?php echo htmlspecialchars($package['receiver_name']); ?>)</p>
                    <p><strong>Weight:</strong> <?php echo $package['weight']; ?> kg</p>
                </div>
 
                <div class="glass card">
                    <h3>Tracking History</h3>
                    <div class="timeline">
                        <?php foreach($history as $item): ?>
                        <div class="timeline-item">
                            <h4 style="color: var(--dhl-yellow);"><?php echo $item['status_update']; ?></h4>
                            <p><?php echo htmlspecialchars($item['location']); ?></p>
                            <small><?php echo date('M d, Y - H:i', strtotime($item['created_at'])); ?></small>
                            <p style="font-size: 0.9rem; opacity: 0.7;"><?php echo htmlspecialchars($item['notes']); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
 
    <script src="script.js"></script>
</body>
</html>
 
