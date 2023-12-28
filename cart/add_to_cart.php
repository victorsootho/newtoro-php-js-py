<?php
include '../includes/db.php';
include '../includes/session.php';

// Redirect user to login page if not logged in
requireLogin();

// Assuming the user's ID is stored in the session upon login
$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = intval($_POST['book_id']);
    $quantity = intval($_POST['quantity']);

    // Check if the book is already in the cart
    $checkSql = "SELECT id FROM shopping_cart WHERE user_id = ? AND book_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $userId, $bookId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $checkStmt->close();

    if ($result->num_rows > 0) {
        // Update the quantity if the book is already in the cart
        $row = $result->fetch_assoc();
        $cartItemId = $row['id'];
        $updateSql = "UPDATE shopping_cart SET quantity = quantity + ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $quantity, $cartItemId);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Insert the book into the cart if it's not already there
        $insertSql = "INSERT INTO shopping_cart (user_id, book_id, quantity) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("iii", $userId, $bookId, $quantity);
        $insertStmt->execute();
        $insertStmt->close();
    }

    // Redirect to the cart view or another appropriate page
    header("Location: view_cart.php");
    exit;
}

// Error handling or redirect if accessed without POST method
header("Location: view_books.php");
exit;
?>
