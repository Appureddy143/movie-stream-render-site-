<?php
// Database Connection
$host = 'localhost';
$username = 'root';
$password = ''; // Update with your database password
$database = 'movie_streaming';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Session Start and Admin Check
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle Movie Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload') {
    // Validate inputs
    if (!empty($_POST['movie_name']) && !empty($_FILES['movie_poster']['name']) && !empty($_FILES['movie_file']['name']) && !empty($_POST['movie_genres'])) {
        $movie_name = $conn->real_escape_string($_POST['movie_name']);
        $movie_poster = $_FILES['movie_poster']['name'];
        $movie_file = $_FILES['movie_file']['name'];
        $movie_genres = implode(", ", $_POST['movie_genres']);
        $release_year = $conn->real_escape_string($_POST['release_year']);
        $imdb_rating = $conn->real_escape_string($_POST['imdb_rating']);
        $about_movie = $conn->real_escape_string($_POST['about_movie']);
        $upload_date = date('Y-m-d H:i:s');

        // File Upload Paths
        $poster_path = "uploads/posters/" . basename($movie_poster);
        $file_path = "uploads/movies/" . basename($movie_file);

        // Move uploaded files
        if (move_uploaded_file($_FILES['movie_poster']['tmp_name'], $poster_path) &&
            move_uploaded_file($_FILES['movie_file']['tmp_name'], $file_path)) {

            // Insert movie into the database
            $insert_query = "INSERT INTO movies (movie_name, movie_poster, movie_file, movie_genres, release_year, imdb_rating, about_movie, upload_date) 
                             VALUES ('$movie_name', '$poster_path', '$file_path', '$movie_genres', '$release_year', '$imdb_rating', '$about_movie', '$upload_date')";

            if ($conn->query($insert_query) === TRUE) {
                echo "<script>alert('Movie uploaded successfully!');</script>";
            } else {
                echo "<script>alert('Error: Could not upload movie.');</script>";
            }
        } else {
            echo "<script>alert('Error: Could not upload files.');</script>";
        }
    } else {
        echo "<script>alert('Error: All fields are required!');</script>";
    }
}

// Handle Movie Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $movie_id = intval($_POST['movie_id']);
    $delete_query = "DELETE FROM movies WHERE id = $movie_id";
    if ($conn->query($delete_query) === TRUE) {
        echo "<script>alert('Movie deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error: Could not delete movie.');</script>";
    }
}

// Fetch All Movies for Admin Panel
$movies_query = "SELECT * FROM movies";
$movies_result = $conn->query($movies_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .movie-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .movie-card {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: calc(25% - 15px);
            text-align: center;
        }
        .movie-card img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .movie-card .btn {
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>
        
        <!-- Movie Upload Form -->
        <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
            <input type="hidden" name="action" value="upload">
            <h2>Upload Movie</h2>
            <div class="mb-3">
                <label for="movie_name" class="form-label">Movie Name</label>
                <input type="text" id="movie_name" name="movie_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="movie_poster" class="form-label">Movie Poster</label>
                <input type="file" id="movie_poster" name="movie_poster" class="form-control" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="movie_file" class="form-label">Movie File</label>
                <input type="file" id="movie_file" name="movie_file" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="movie_genres" class="form-label">Genres</label>
                <select id="movie_genres" name="movie_genres[]" class="form-control" multiple required>
                    <option value="Action">Action</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Drama">Drama</option>
                    <option value="Horror">Horror</option>
                    <option value="Thriller">Thriller</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="release_year" class="form-label">Release Year</label>
                <input type="number" id="release_year" name="release_year" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="imdb_rating" class="form-label">IMDB Rating</label>
                <input type="text" id="imdb_rating" name="imdb_rating" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="about_movie" class="form-label">About Movie</label>
                <textarea id="about_movie" name="about_movie" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Upload Movie</button>
        </form>

        <!-- Movie List -->
        <h2>Uploaded Movies</h2>
        <div class="movie-grid">
            <?php while ($movie = $movies_result->fetch_assoc()): ?>
                <div class="movie-card">
                    <img src="<?php echo $movie['movie_poster']; ?>" alt="Poster">
                    <h5><?php echo $movie['movie_name']; ?></h5>
                    <p>Genres: <?php echo $movie['movie_genres']; ?></p>
                    <p>Release Year: <?php echo $movie['release_year']; ?></p>
                    <p>IMDB: <?php echo $movie['imdb_rating']; ?></p>
                    <p><?php echo $movie['about_movie']; ?></p>
                    <form action="" method="POST" style="display:inline-block;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
