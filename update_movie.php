<?php
require_once './db.php';

// Retrieve movie data from $_POST variables
$movieId = sanitize($mysqli, $_POST['movie_id']);
$title = sanitize($mysqli, $_POST['title']);
$director = sanitize($mysqli, $_POST['director']);
$year = sanitize($mysqli, $_POST['year']);
$genre = sanitize($mysqli, $_POST['genre']);

// Prepare the update query
$updateQuery = "UPDATE movies SET title = ?, director = ?, year = ?, genre = ? WHERE id = ?";
$stmt = $mysqli->prepare($updateQuery);

if ($stmt) {
    // Bind parameters to the placeholders
    $stmt->bind_param('ssisi', $title, $director, $year, $genre, $movieId);

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

// Close database connection
$mysqli->close();
