<?php
// Use db.php login page to log in and connect to database
require_once './db.php';

// create names for the tables
$moviesTable = 'movies';
$genresTable = 'genres';

// Create movies table with id, title, director, year, genre
// Genre can only contain an id from genres table
$moviesQuery = "CREATE TABLE IF NOT EXISTS $moviesTable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    director VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    genre INT NOT NULL,
    FOREIGN KEY (genre) REFERENCES genres(id)
)";

// Create genres table with id and name
$genresQuery = "CREATE TABLE IF NOT EXISTS $genresTable (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30) UNIQUE NOT NULL
)";

// Run genres query and check if successfully, otherwise send error information
if ($mysqli->query($genresQuery) === TRUE) {
    echo "Table '$genresTable' created successfully or already exists.\n";
} else {
    echo "Error creating table: " . $mysqli->error;
}

// Run movies query and check if successfully, otherwise send error information
if ($mysqli->query($moviesQuery) === TRUE) {
    echo "Table '$moviesTable' created successfully or already exists.\n";
} else {
    echo "Error creating table: " . $mysqli->error;
}

// Array with sample genres
$genres = array(
    "Action",
    "Comedy",
    "Drama",
    "Horror",
    "Romance",
    "Science Fiction"
);

// Insert genres into genres table
foreach ($genres as $genre) {
    $sql = "INSERT INTO genres (name) VALUES ('$genre')";
    $mysqli->query($sql);
}

// Array with sample movie data
$movies = array(
    array("The Shawshank Redemption", "Frank Darabont", 1994, "Drama"),
    array("Pulp Fiction", "Quentin Tarantino", 1994, "Crime"),
    array("The Dark Knight", "Christopher Nolan", 2008, "Action"),
    array("Inception", "Christopher Nolan", 2010, "Science Fiction"),
    array("The Matrix", "Lana Wachowski, Lilly Wachowski", 1999, "Science Fiction"),
    array("Forrest Gump", "Robert Zemeckis", 1994, "Drama")
);

// Insert movies into movies table
foreach ($movies as $movie) {
    $title = $movie[0];
    $director = $movie[1];
    $year = $movie[2];
    $genre = $movie[3];

    // Retrieve genre id from genres table
    $sql = "SELECT id FROM genres WHERE name = '$genre'";
    $result = $mysqli->query($sql);

    // if there is an id that have generes name - create genreId with id number from genre colummn
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $genreId = $row["id"];

        // Insert movie into movies table with genre id
        $sql = "INSERT INTO movies (title, director, year, genre) VALUES ('$title', '$director', $year, $genreId)";
        $mysqli->query($sql);
    }
}

// Close database connection
$mysqli->close();

echo "Sample movie data inserted successfully.";
