<?php
require_once './db.php';

// Retrieve movie data from $_POST variables and sanitize them
$title = sanitize($mysqli, $_POST['title']);
$director = sanitize($mysqli, $_POST['director']);
$year = sanitize($mysqli, $_POST['year']);
$genre = sanitize($mysqli, $_POST['genre']);

// Prepare the insert query
$sql = "INSERT INTO movies (title, director, year, genre) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    // Bind parameters to the placeholders
    $stmt->bind_param('ssis', $title, $director, $year, $genre);

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
