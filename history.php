<?php
// Include the database connection file
require 'db_connection.php';

// Assume the user ID is stored in the session after login
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #343a40;
            color: #fff;
        }

        .history-container {
            padding: 20px;
        }

        .history-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .history-item img {
            width: 150px;
            height: 100px;
            object-fit: cover;
        }

        .history-info {
            flex-grow: 1;
            padding: 10px;
        }

        .history-info h5 {
            margin: 0;
        }

        .progress-bar {
            background-color: #28a745;
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
        <div class="logo">Movie Stream</div>
        <div>
            <a href="profile.php" class="btn btn-primary">Profile</a>
            <a href="home.php" class="btn btn-secondary">Home</a>
        </div>
    </div>

    <!-- Watch History -->
    <div class="history-container">
        <h2>Your Watch History</h2>
        <?php
        // Fetch the user's watch history
        $sql_history = "
            SELECT 
                m.movie_name AS name, 
                m.movie_poster AS poster, 
                w.watch_percentage AS watched
            FROM watch_history w
            INNER JOIN movies m ON w.movie_id = m.id
            WHERE w.user_id = $user_id
            ORDER BY w.last_watched DESC";

        $result_history = $conn->query($sql_history);

        if ($result_history->num_rows > 0) {
            while ($row = $result_history->fetch_assoc()) {
                echo "
                    <div class='history-item'>
                        <img src='uploads/{$row['poster']}' alt='{$row['name']}'>
                        <div class='history-info'>
                            <h5>{$row['name']}</h5>
                            <div class='progress'>
                                <div class='progress-bar' role='progressbar' style='width: {$row['watched']}%;' aria-valuenow='{$row['watched']}' aria-valuemin='0' aria-valuemax='100'></div>
                            </div>
                            <p>{$row['watched']}% watched</p>
                        </div>
                    </div>
                ";
            }
        } else {
            echo "<p>You haven't watched any movies yet!</p>";
        }
        ?>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Movie Stream | All Rights Reserved
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
