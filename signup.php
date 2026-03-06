<?php
session_start();
require_once 'db.php';
 
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        header("Location: login.php?msg=Signup successful! Please login.");
        exit();
    } catch (PDOException $e) {
        $error = "Username or Email already exists.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | DHL Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
 
    <div class="auth-box glass">
        <h2>Create Account</h2>
        <?php if($error): ?><p style="color:red; text-align:center;"><?php echo $error; ?></p><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="input-field" required style="width:100%;">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="input-field" required style="width:100%;">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="input-field" required style="width:100%;">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Register</button>
        </form>
        <p style="margin-top:20px; text-align:center;">Already have an account? <a href="login.php" style="color:var(--dhl-yellow);">Login</a></p>
    </div>
 
    <script src="script.js"></script>
</body>
</html>
 
