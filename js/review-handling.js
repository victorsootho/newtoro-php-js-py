// Function to handle the submission of a new review
function submitReview() {
    var form = document.getElementById('reviewForm');
    var formData = new FormData(form);

    fetch('../books/handle_reviews.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data); // For debugging
            if (data.status === 'success') {
                // Optionally clear the form
                form.reset();
                // Load reviews again to display the new one
                loadReviews();
            } else {
                // Handle error
                alert('Error submitting review: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the review.');
        });
}

// Function to load and display reviews
function loadReviews() {
    var bookId = document.getElementById('reviewForm').book_id.value;

    fetch('../books/handle_reviews.php?book_id=' + bookId)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                var reviewsDiv = document.getElementById('reviews');
                reviewsDiv.innerHTML = ''; // Clear current content
                data.reviews.forEach(function(review) {
                    var reviewElem = document.createElement('div');
                    reviewElem.innerHTML = `<strong>Rating:</strong> ${review.rating} <br>
                                        <strong>Review by:</strong> ${review.username || 'Anonymous'}<br> <!-- Display username if available -->
                                        <strong>Review:</strong> ${review.review_text}`;
                    reviewsDiv.appendChild(reviewElem);
                });
            } else {
                console.log('Error fetching reviews: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Event listeners for form submission and page load
document.addEventListener('DOMContentLoaded', function() {
    var reviewForm = document.getElementById('reviewForm');
    reviewForm.addEventListener('submit', function(event) {
        event.preventDefault();
        submitReview();
    });

    // Load reviews when the page is loaded
    loadReviews();
});
