<?php
session_start();

include '../includes/db.php'; // Adjust the path as needed for your includes

// Function to sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the request is for saving a new review or fetching reviews
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Save a new review
    $bookId = isset($_POST['book_id']) ? sanitizeInput($_POST['book_id']) : '';
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
    $rating = isset($_POST['rating']) ? sanitizeInput($_POST['rating']) : '';
    $reviewText = isset($_POST['review_text']) ? sanitizeInput($_POST['review_text']) : '';

    // SQL to insert a new review
    $sql = "INSERT INTO reviews (book_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $bookId, $userId, $rating, $reviewText);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Review added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding review']);
    }

    $stmt->close();
} else {
    // Fetch reviews
    $bookId = isset($_GET['book_id']) ? sanitizeInput($_GET['book_id']) : '';

    // SQL to fetch reviews
    $sql = "SELECT * FROM reviews WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    echo json_encode(['status' => 'success', 'reviews' => $reviews]);
    $stmt->close();
}

$conn->close();
?>
