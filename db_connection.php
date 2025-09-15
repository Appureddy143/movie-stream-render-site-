<?php
$servername = getenv('DB_HOST') ?: 'localhost'; // Use localhost for testing, or DB_HOST if set
$username = getenv('DB_USER') ?: 'root';  // Default to 'root' if not set
$password = getenv('DB_PASS') ?: ''; // Empty password by default
$dbname = getenv('DB_NAME') ?: 'movie_streaming';  // Default database

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
