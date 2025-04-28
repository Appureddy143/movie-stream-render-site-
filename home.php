<?php
// Include the database connection file
require 'db_connection.php';

// Search functionality
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
}

// Query for movies
$sql_movies = "
    SELECT 
        id,
        movie_name AS name,
        movie_poster AS poster,
        movie_genres AS genres,
        release_year,
        imdb_rating,
        language,
        description
    FROM movies";

if (!empty($search_query)) {
    $sql_movies .= " WHERE movie_name LIKE '%$search_query%' OR movie_genres LIKE '%$search_query%'";
}

$sql_movies .= " ORDER BY upload_date DESC LIMIT 20";

$result_movies = $conn->query($sql_movies);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Infinity</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #343a40;
            color: #fff;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .search-bar {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .search-bar input[type="text"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }

        .movie-grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }

        @media (max-width: 992px) {
            .movie-grid-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .movie-grid-container {
                grid-template-columns: 1fr;
            }
        }

        .movie-grid {
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .movie-grid:hover {
            transform: scale(1.05);
        }

        .movie-grid img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .movie-info {
            padding: 10px;
        }

        .movie-info p {
            margin: 5px 0;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <a href="home.php" class="logo">Infinity</a>
        <div class="nav-links">
            <form class="search-bar" method="GET" action="">
                <input type="text" name="search" placeholder="Search movies..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
            </form>
            <a href="home.php">Home</a>
            <a href="profile.php">Profile</a>
            <a href="history.php">History</a>
            <a href="about.php">About</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Movie Grid -->
    <div class="movie-grid-container">
        <?php
        if ($result_movies->num_rows > 0) {
            while ($row = $result_movies->fetch_assoc()) {
                $poster_path = !empty($row['poster']) ? "uploads/posters/" . $row['poster'] : "images/default-poster.png";
                echo "
                    <div class='movie-grid'>
                        <a href='movie.php?id={$row['id']}'>
                            <img src='$poster_path' alt='{$row['name']}' 
                                 onerror=\"this.onerror=null;this.src='images/default-poster.png';\">
                        </a>
                        <div class='movie-info'>
                            <p class='movie-name'><strong>{$row['name']}</strong></p>
                            <p class='movie-genres'>Genre: {$row['genres']}</p>
                            <p class='movie-year'>Release Year: {$row['release_year']}</p>
                            <p class='movie-rating'>
                                <img src='images/imdb.png' alt='IMDb' style='height:20px;'> {$row['imdb_rating']}
                            </p>
                            <p class='movie-language'>Language: {$row['language']}</p>
                        </div>
                    </div>
                ";
            }
        } else {
            echo "
                <div style='text-align: center; margin-top: 20px;'>
                    <p>No movies available right now. Please check back later!</p>
                </div>
            ";
        }
        ?>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Infinity Entertainment | All Rights Reserved
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
