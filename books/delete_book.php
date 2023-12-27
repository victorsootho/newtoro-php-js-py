<?php
include 'includes/db.php';
include 'includes/session.php';

// Redirect user to login page if not logged in
requireLogin();

$message = '';

// Check if the book ID is set in the query string
if (isset($_GET['id'])) {
    $bookId = intval($_GET['id']);

    // Prepare SQL statement to delete the book
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);

    if ($stmt->execute()) {
        $message = "Book deleted successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $message = "No book specified to delete.";
}

$conn->close();

// Redirect back to the book list or display a message
header("Location: view_books.php");
exit;
?>
