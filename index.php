<?php
session_start();
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DHL Clone | Global Logistics</title>
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
                <a href="track.php">Track</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php">Dashboard</a>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="signup.php">Sign Up</a>
                <?php endif; ?>
            </nav>
        </header>
 
        <section class="hero">
            <h1>Excellence. <span>Simply Delivered.</span></h1>
            <p>Track your shipment, manage your packages, and experience the next level of logistics with our advanced platform.</p>
 
            <form action="track.php" method="GET" class="track-form glass">
                <input type="text" name="id" class="input-field" placeholder="Enter Tracking ID (e.g. DHL12345)" required>
                <button type="submit" class="btn btn-primary">Track Now</button>
            </form>
        </section>
 
        <section class="grid">
            <div class="card glass">
                <h3>Global Reach</h3>
                <p>Deliver to over 220 countries and territories with speed and reliability.</p>
            </div>
            <div class="card glass">
                <h3>Real-time Tracking</h3>
                <p>Stay updated with our advanced tracking system and status history.</p>
            </div>
            <div class="card glass">
                <h3>Secure Handling</h3>
                <p>Your packages are handled with the utmost care and security protocols.</p>
            </div>
        </section>
    </div>
 
    <script src="script.js"></script>
</body>
</html>
 
