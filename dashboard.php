<?php
include 'includes/session.php';
requireLogin(); // Redirects to login page if not logged in

// Rest of your dashboard code
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<h1>Welcome to Your Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
<!-- Dashboard content -->
</body>
</html>
