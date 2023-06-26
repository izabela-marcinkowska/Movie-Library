<?php
//Login information to database
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'movies';

// Create a new MySQLi instance
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_errno) {
    die('Failed to connect to MySQL: ' . $mysqli->connect_error);
}

// functions to sanitate input
function sanitizeString($var)
{
  //removing slashes from a string
  $var = stripslashes($var);
  //changes html syntax to text
  $var = htmlentities($var);
  //removing tags from a string
  $var = strip_tags($var);
  return $var;
}

function sanitize($connection, $var)
{ 
  //removing escaping characters /n 
  $var = $connection->real_escape_string($var);
  $var = sanitizeString($var);
  return $var;
}