<?php
session_start();
// Include necessary files and start the session
include '../includes/db.php';
include '../includes/session.php';

// Get the book ID from the URL
$bookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

// Initialize a variable to hold book details
$book = null;

// Fetch book details from the database using $bookId
if ($bookId) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    }
    $stmt->close();
}

// If no book found, redirect or display a message
if (!$bookId || !$book) {
    echo "<p>Book not found.</p>";
    // Optionally, redirect to another page
    // header("Location: view_books.php");
    // exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Details</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<h2>Book Details</h2>

<?php if ($book): ?>
    <!-- Display book information here -->
    <div id="bookInfo">
        <h3><?php echo htmlspecialchars($book['title']); ?></h3>
        <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
        <p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
        <p>Price: <?php echo htmlspecialchars($book['price']); ?></p>
        <p>Description: <?php echo htmlspecialchars($book['description']); ?></p>
        <img src="<?php echo htmlspecialchars($book['image_url']); ?>" alt="Book Image" style="height:100px;">
    </div>

    <!-- Show the username for the review -->
    <h3><?php echo "Review by " . htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?></h3>

    <!-- Reviews Section -->
    <div id="reviews">
        <!-- AJAX will load reviews here -->
    </div>

    <!-- Review Submission Form -->
    <form id="reviewForm">
        <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
        <label for="rating">Rating:</label>
        <select name="rating" id="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <!-- More rating options -->
        </select>
        <label for="reviewText">Review:</label>
        <textarea name="review_text" id="reviewText" required></textarea>
        <button type="submit">Submit Review</button>
    </form>
<?php endif; ?>


<script src="../js/review-handling.js"></script> <!-- JavaScript for handling review AJAX -->
</body>
</html>
