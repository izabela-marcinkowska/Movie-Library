<?php
require_once './db.php';

// Retrieve form data and sanitize
$movieId = sanitize($mysqli,$_POST['movie_id']);

// Prepare the delete query
$deleteQuery = "DELETE FROM movies WHERE id = ?";
$stmt = $mysqli->prepare($deleteQuery);

if ($stmt) {
    // Bind the movieId to the placeholder
    $stmt->bind_param('i', $movieId);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: /');
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: " . $mysqli->error;
}

// Close the database connection
$mysqli->close();
