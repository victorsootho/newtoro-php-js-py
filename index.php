<?php
include 'includes/session.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php if (isLoggedIn()): ?>
    <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="dashboard.php">Go to Dashboard</a></p>
<?php else: ?>
    <p><a href="login.php">Login</a> or <a href="register.php">Register</a></p>
<?php endif; ?>
<!-- Other page content -->
</body>
</html>
