<?php
require_once './db.php';

// Retrieve movie ID from the query string or form submission
$movieId = $_GET['id']; // Assuming you pass the movie ID as a query parameter

// Get back to index if id is not set
if (!isset($_GET['id'])) {
    header('Location: /');
}

// Fetch movie information from the database
$selectQuery = "SELECT movies.*, genres.id AS genre_id, genres.name
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
    <title>Edit movie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
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
    <div class="container">
        <?php

        // Display editable form with movie details
        if ($result && $result->num_rows > 0) {
            $movie = $result->fetch_assoc();
        ?>
            <form class="pure-form pure-form-stacked" action="update_movie.php" method="POST">
                <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $movie['title']; ?>" required>

                <label for="director">Director:</label>
                <input type="text" name="director" id="director" value="<?php echo $movie['director']; ?>" required>

                <label for="year">Year:</label>
                <input type="text" name="year" id="year" value="<?php echo $movie['year']; ?>" required>

                <!-- Get avaliable genres from genre column -->
                <?php
                $selectGenresQuery = "SELECT id, name FROM genres";
                $genresResult = $mysqli->query($selectGenresQuery);

                // Go through all avaliable genres
                while ($row = $genresResult->fetch_assoc()) {
                    $genreName = $row['name'];
                    $genreId = $row['id'];
                ?> 
                    <!-- Add those to a radio input choices  -->
                    <label class="pure-radio">
                        <input type="radio" name="genre" value="<?php echo $genreId; ?>" required <?php echo $genreId == $movie['genre_id'] ? 'checked' : ''; ?>>
                        <?php echo $genreName; ?>
                    </label>
                <?php
                }

                $genresResult->free_result();
                ?>

                <button type="submit" class="pure-button pure-button-primary">Update Movie</button>
            </form>
        <?php
        } else {
            echo "Movie not found.";
        }

        // Close the database connection
        $mysqli->close();
        ?>
    </div>
</body>

</html>
