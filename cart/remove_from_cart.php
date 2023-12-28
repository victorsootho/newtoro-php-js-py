<?php
include '../includes/db.php';
include '../includes/session.php';

// Redirect user to login page if not logged in
requireLogin();

if (isset($_GET['cart_id'])) {
    $cartItemId = intval($_GET['cart_id']);
    $userId = $_SESSION['user_id']; // Assuming user's ID is stored in session

    // Prepare SQL statement to delete the cart item
    $sql = "DELETE FROM shopping_cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cartItemId, $userId);

    if ($stmt->execute()) {
        // Redirect back to the cart view with a success message
        header("Location: view_cart.php?msg=Item removed successfully");
    } else {
        // Redirect back to the cart view with an error message
        header("Location: view_cart.php?msg=Error removing item");
    }

    $stmt->close();
} else {
    // Redirect back to the cart view if no cart item ID is provided
    header("Location: view_cart.php?msg=No item specified");
}

$conn->close();
exit;
?>
