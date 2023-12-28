<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<form action="login.php" method="post" id="login-form">
    Username/Email: <input type="text" name="username_email" required><br>
    <div class="error-message" id="username-email-error"></div>
    Password: <input type="password" name="password" required><br>
    <div class="error-message" id="password-error"></div>
    <input type="submit" name="submit" value="Login">
</form>

<script src="js/form-validation.js"></script>
</body>
</html>

<?php
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = sanitizeInput($_POST["username_email"]);
    $password = $_POST["password"]; // Don't hash yet, as we need to compare with the hashed password in the database

    // SQL to check user
    $sql = "SELECT id, username, email, password FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct
            // Start session, save user info into session variables
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Redirect to a new page or user dashboard
            header("Location: dashboard.php"); // Replace with the location you want
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username/email.";
    }

    $stmt->close();
    $conn->close();
}
?>
