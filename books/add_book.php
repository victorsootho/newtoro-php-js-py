<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../includes/db.php';
include '../includes/functions.php';
include '../includes/session.php';

// Redirect user to login page if not logged in
requireLogin();

$message = ''; // For displaying messages to the user

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitizeInput($_POST['title']);
    $author = sanitizeInput($_POST['author']);
    $isbn = sanitizeInput($_POST['isbn']);
    $price = sanitizeInput($_POST['price']);
    $description = sanitizeInput($_POST['description']);
    $image_url = sanitizeInput($_POST['image_url']);

    // Prepare SQL statement to insert book data
    $sql = "INSERT INTO books (title, author, isbn, price, description, image_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdss", $title, $author, $isbn, $price, $description, $image_url);

    if ($stmt->execute()) {
        $message = "New book added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Book</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<h2>Add New Book</h2>
<?php if ($message != '') echo "<p>$message</p>"; ?>
<form action="add_book.php" method="post">
    Title: <input type="text" name="title" required><br>
    Author: <input type="text" name="author" required><br>
    ISBN: <input type="text" name="isbn"><br>
    Price: <input type="number" name="price" step="0.01" required><br>
    Description: <textarea name="description"></textarea><br>
    Image URL: <input type="text" name="image_url"><br>
    <input type="submit" value="Add Book">
</form>
</body>
</html>
