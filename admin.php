<?php
session_start();
require_once 'db.php';
 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied. Admins Only.");
}
 
// Fetch all packages
$stmt = $pdo->query("SELECT p.*, u.username FROM packages p LEFT JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
$packages = $stmt->fetchAll();
 
// Fetch all users
$ustmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $ustmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel | DHL Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
 
    <div class="container" style="max-width: 1400px;">
        <header>
            <div class="logo">DHL<span>ADMIN</span></div>
            <nav>
                <a href="index.php">View Site</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>
 
        <h2 style="margin-top:40px;">Admin Management</h2>
 
        <div class="grid" style="grid-template-columns: 1fr;">
            <div class="glass card">
                <h3>Manage Packages</h3>
                <table>
                    <thead>
                        <tr>
                            <th>T-ID</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Status</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($packages as $pkg): ?>
                        <tr>
                            <td><?php echo $pkg['tracking_id']; ?></td>
                            <td><?php echo htmlspecialchars($pkg['sender_name']); ?></td>
                            <td><?php echo htmlspecialchars($pkg['receiver_name']); ?></td>
                            <td><span class="status-badge status-<?php echo str_replace(' ', '-', $pkg['status']); ?>"><?php echo $pkg['status']; ?></span></td>
                            <td><?php echo htmlspecialchars($pkg['username'] ?? 'Guest'); ?></td>
                            <td>
                                <a href="update_status.php?id=<?php echo $pkg['id']; ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;">Update</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
 
            <div class="glass card">
                <h3>Manage Users</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['username']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo $u['role']; ?></td>
                            <td><?php echo $u['created_at']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 
    <script src="script.js"></script>
</body>
</html>
 
