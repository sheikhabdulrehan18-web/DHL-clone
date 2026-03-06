<?php
session_start();
require_once 'db.php';
 
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
 
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
 
        if ($user['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | DHL Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
 
    <div class="auth-box glass">
        <h2>Login</h2>
        <?php if(isset($_GET['msg'])): ?><p style="color:green; text-align:center;"><?php echo $_GET['msg']; ?></p><?php endif; ?>
        <?php if($error): ?><p style="color:red; text-align:center;"><?php echo $error; ?></p><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="input-field" required style="width:100%;">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="input-field" required style="width:100%;">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Login</button>
        </form>
        <p style="margin-top:20px; text-align:center;">Don't have an account? <a href="signup.php" style="color:var(--dhl-yellow);">Sign Up</a></p>
    </div>
 
    <script src="script.js"></script>
</body>
</html>
 
