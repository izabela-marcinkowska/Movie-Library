<?php
// use db.php to log in to database
require_once './db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Basic CSS style from pure.css library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css" integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <title>Movies database</title>

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
        <!-- FORM -->
        <form class="pure-form pure-form-stacked" action="add_movie.php" method="POST">
            <fieldset>
                <div>
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" required>
                </div>

                <div>
                    <label for="director">Director:</label>
                    <input type="text" name="director" id="director" required>
                </div>

                <div>
                    <label for="year">Year:</label>
                    <input type="text" name="year" id="year" required>
                </div>

                <div>
                    <label for="genre">Genre:</label>
                    <?php
                    // Retrieve genres from the database
                    $selectGenresQuery = "SELECT id, name FROM genres";
                    $stmtGenres = $mysqli->query($selectGenresQuery);

                    $index = 0;

                    // Get every name of genre from genre table
                    while ($row = $stmtGenres->fetch_assoc()) {
                        $genreName = $row['name'];
                        $genreId = $row['id'];
                        $index++;
                    ?>
                        <!-- Put every genre name into radio list of choices. -->
                        <label class="pure-radio">
                            <input type="radio" name="genre" value="<?php echo $genreId; ?>" required <?php echo $index == 1 ? 'checked' : ''; ?>>
                            <?php echo $genreName; ?>
                        </label>
                    <?php
                    }
                    // function to clear the memory 
                    $stmtGenres->free_result();
                    ?>
                </div>

                <div class="pure-controls">
                    <input type="submit" value="Add Movie" class="pure-button pure-button-primary">
                </div>
            </fieldset>
        </form>

        <?php
        // Retrieve all movies from the database and get genre name from genre column
        $sql = "SELECT movies.id, movies.title, movies.director, movies.year, genres.name AS genre
        FROM movies
        INNER JOIN genres ON movies.genre = genres.id";
        $result = $mysqli->query($sql);
        ?>

        <table class="pure-table pure-table-horizontal">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Director</th>
                    <th>Year</th>
                    <th>Genre</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Loop through each movie and generate table rows
                while ($row = $result->fetch_assoc()) {
                    $title = $row['title'];
                    $year = $row['year'];
                    $director = $row['director'];
                    $genre = $row['genre'];
                ?>

                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $director; ?></td>
                        <td><?php echo $year; ?></td>
                        <td><?php echo $genre; ?></td>
                        <td>
                            <a href="edit_movie.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete_movie.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>

                <?php
                }
                $result->free_result();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
