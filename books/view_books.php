<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/db.php';
include '../includes/session.php';

// Redirect user to login page if not logged in
requireLogin();

$message = '';

// Fetch all books from the database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Books</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<h2>Book Catalog</h2>

<!-- Sorting Options -->
<label for="sortOption">Sort by:</label>
<select id="sortOption">
    <option value="title">Title</option>
    <option value="author">Author</option>
    <option value="price">Price</option>
    <!-- Add more sorting options as needed -->
</select>

<!-- Filtering Options -->
<label for="filterInput">Search:</label>
<input type="text" id="filterInput" placeholder="Search...">

<?php if ($message != '') echo "<p>$message</p>"; ?>
<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>ISBN</th>
        <th>Price</th>
        <th>Description</th>
        <th>Image</th>
        <th>Action</th>
        <th>Add to Cart</th> <!-- New column for Add to Cart -->
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td data-label='title'>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td data-label='author'>" . htmlspecialchars($row['author']) . "</td>";
            echo "<td data-label='isbn'>" . htmlspecialchars($row['isbn']) . "</td>";
            echo "<td data-label='price'>" . htmlspecialchars($row['price']) . "</td>";
            echo "<td data-label='description'>" . htmlspecialchars($row['description']) . "</td>";
            echo "<td data-label='image'><img src='" . htmlspecialchars($row['image_url']) . "' alt='Book Image' style='height:100px;'></td>";
            echo "<td data-label='action'><a href='delete_book.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this book?\");'>Delete</a></td>";
            echo "<td data-label='add-to-cart'>
                <form action='../cart/add_to_cart.php' method='post'>
                    <input type='hidden' name='book_id' value='" . $row['id'] . "'>
                    <input type='number' name='quantity' value='1' min='1' max='10' style='width: 50px;'>
                    <input type='submit' value='Add to Cart'>
                </form>
              </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No books found</td></tr>"; // Updated colspan to 8
    }
    ?>
</table>
<?php $conn->close(); ?>
<script src="../js/book-interactions.js"></script>
</body>
</html>
