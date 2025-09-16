<?php
// Enable error reporting for debugging (REMOVE in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Fetch environment variables or fallback to hardcoded values
$host     = getenv('DB_HOST') ?: 'dpg-d33ubc7diees739skee0-a.oregon-postgres.render.com';
$port     = getenv('DB_PORT') ?: '5432';
$dbname   = getenv('DB_NAME') ?: 'movie_streaming_d4xr';
$user     = getenv('DB_USER') ?: 'movie_streaming_d4xr_user';
$password = getenv('DB_PASS') ?: '5z4fBfUcn5TRUiz19mkEKLZ8SlO515Yc'; // Replace with your actual password

// PostgreSQL connection string with SSL required for Render
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require";

// Connect to PostgreSQL
$conn = pg_connect($conn_string);
if (!$conn) {
    die("❌ Error: Unable to connect to PostgreSQL database.");
}

// Handle POST login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = pg_escape_string($conn, $_POST['email']);
    $password_input = $_POST['password'];

    $query = "SELECT id, username, password, email FROM users WHERE email = $1";
    $result = pg_query_params($conn, $query, [$email]);

    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);

        if (password_verify($password_input, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['email'] === 'admin@example.com' ? 'admin' : 'user';

            // Redirect based on role
            header("Location: " . ($_SESSION['role'] === 'admin' ? 'admin_panel.php' : 'home.php'));
            exit;
        } else {
            echo "<script>alert('❌ Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('❌ User not found!');</script>";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Movie Streaming</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        .bg-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }
        .container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-box {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 100%;
        }
        .logo img {
            width: 120px;
        }
    </style>
</head>
<body>

    <!-- Background video -->
    <video class="bg-video" autoplay muted loop>
        <source src="elements/video/back.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <!-- Login Form -->
    <div class="container">
        <div class="form-box">
            <div class="text-center mb-4 logo">
                <img src="elements/img/logo/logo.png" alt="Logo">
            </div>
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="Enter email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Enter password">
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
