<?php
require_once './db.php';

// Retrieve movie ID from the query string or form submission
$movieId = $_GET['id']; // Assuming you pass the movie ID as a query parameter

if (!isset($_GET['id'])) {
  header('Location: /');
}

// Fetch movie information from the database
// Prepare the select query and set a placeholder for a movie id 
$selectQuery = "SELECT movies.id, movies.title, movies.director, movies.year, genres.id AS genre_id, genres.name
  FROM movies
  JOIN genres ON movies.genre = genres.id
  WHERE movies.id = $movieId";
$result = $mysqli->query($selectQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
  <title>Confirm deletion of movie</title>
  <style>
    body {
      padding: 1em;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <?php

  // Display movie details with confirmation message
  if ($result && $result->num_rows > 0) {
    $movie = $result->fetch_assoc();
  ?>
    <h2>Confirm Deletion</h2>
    <p><strong>Title:</strong> <?php echo $movie['title']; ?></p>
    <p><strong>Director:</strong> <?php echo $movie['director']; ?></p>
    <p><strong>Year:</strong> <?php echo $movie['year']; ?></p>
    <p><strong>Genre:</strong> <?php echo $movie['name']; ?></p>

    <!-- Two inputs where one invisible to user for sending POST information with id.  -->
    <form class="pure-form" action="confirm_delete.php" method="POST">
      <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
      <input type="submit" class="pure-button pure-button-primary" value="Delete Movie">
    </form>
  <?php
  } else {
    echo "Movie not found.";
  }

  // Close the database connection
  $mysqli->close();
  ?>
</body>

</html>
