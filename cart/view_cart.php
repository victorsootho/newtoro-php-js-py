<?php
include '../includes/db.php';
include '../includes/session.php';

// Redirect user to login page if not logged in
requireLogin();

$userId = $_SESSION['user_id']; // Assuming user's ID is stored in session

// Query to get cart items along with book details
$sql = "SELECT shopping_cart.id as cart_id, shopping_cart.quantity, books.title, books.price, books.id as book_id
        FROM shopping_cart 
        JOIN books ON shopping_cart.book_id = books.id 
        WHERE shopping_cart.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Cart</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<h2>Your Shopping Cart</h2>

<?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Title</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
            echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
            echo "<td>$" . (htmlspecialchars($row['quantity']) * htmlspecialchars($row['price'])) . "</td>";
            echo "<td><a href='remove_from_cart.php?cart_id=" . $row['cart_id'] . "' onclick='return confirm(\"Are you sure you want to remove this item from your cart?\");'>Remove</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>

<?php $conn->close(); ?>
</body>
</html>
