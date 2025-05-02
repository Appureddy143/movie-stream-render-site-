<?php
require('db_connection.php');

// Fetch movie details using the provided movie ID
if (isset($_GET['id'])) {
    $movie_id = (int) $_GET['id'];
    $query = "SELECT * FROM movies WHERE id = $movie_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        die('Movie not found.');
    }
} else {
    die('No movie selected.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['movie_name']); ?> - Download Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        /* Background and general styles */
        body {
            margin: 0;
            padding: 0;
            background: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .movie-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-top: 50px;
        }

        .movie-poster {
            width: 300px;
            height: 450px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .movie-details {
            text-align: center;
            margin-top: 20px;
        }

        .movie-details h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .movie-details p {
            margin: 5px 0;
        }

        .buttons {
            margin-top: 20px;
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn-custom {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-stream {
            background-color: #e50914;
        }

        .btn-download {
            background-color: #007bff;
        }

        /* Loading Animation */
        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #121212;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #loading .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #e50914;
            width: 80px;
            height: 80px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loading Animation -->
    <div id="loading">
        <div class="loader"></div>
    </div>

    <!-- Movie Content -->
    <div class="movie-container">
        <img src="<?php echo htmlspecialchars($movie['movie_poster']); ?>" alt="<?php echo htmlspecialchars($movie['movie_name']); ?>" class="movie-poster">
        <div class="movie-details">
            <h1><?php echo htmlspecialchars($movie['movie_name']); ?></h1>
            <p><strong>Release Year:</strong> <?php echo htmlspecialchars($movie['release_year']); ?></p>
            <p><strong>IMDB Rating:</strong> <?php echo htmlspecialchars($movie['imdb_rating']); ?>/10</p>
            <p><strong>Genres:</strong> <?php echo htmlspecialchars($movie['movie_genres']); ?></p>
            <p><strong>Language:</strong> <?php echo htmlspecialchars($movie['language']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($movie['description']); ?></p>
        </div>
        <div class="buttons">
            <a href="<?php echo htmlspecialchars($movie['movie_file']); ?>" class="btn-custom btn-stream" target="_blank">Stream Now</a>
            <a href="<?php echo htmlspecialchars($movie['movie_file']); ?>" class="btn-custom btn-download" download>Download</a>
        </div>
    </div>

    <script>
        // Hide the loader after the page is fully loaded
        window.addEventListener('load', () => {
            const loader = document.getElementById('loading');
            loader.style.display = 'none';
        });
    </script>
</body>
</html>
