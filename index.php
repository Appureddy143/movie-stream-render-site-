<?php
session_start();

$host = getenv('DB_HOST') ?: 'dpg-d33ubc7diees739skee0-a';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'movie_streaming_d4xr';
$user = getenv('DB_USER') ?: 'movie_streaming_d4xr_user';
$password = getenv('DB_PASS') ?: 'your_password_here';

// Create connection string
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Connect to PostgreSQL
$conn = pg_connect($conn_string);

if (!$conn) {
    die("Error: Unable to connect to PostgreSQL database.");
}

// Now, use pg_query, pg_prepare, pg_execute for queries

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = pg_escape_string($conn, $_POST['email']);
    $password_input = $_POST['password'];

    // Prepare statement
    $result = pg_query_params($conn, 'SELECT id, username, password, email FROM users WHERE email = $1', array($email));

    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);

        // Verify password (assuming password stored as hashed)
        if (password_verify($password_input, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['email'] === 'admin@example.com' ? 'admin' : 'user';

            if ($_SESSION['role'] === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: home.php");
            }
            exit;
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }

        .bg-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 120%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background: rgba(255, 255, 255, 0.41);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-box .form-control {
            margin-bottom: 15px;
        }

        .form-box .btn {
            width: 100%;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
        }
    </style>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script> 
</head>
<body>
<div id="loading-screen">
    <div class="spinner-box">
        <div class="circle-border">
            <div class="circle-core"></div>
        </div>
        <h3>Loading, please wait...</h3>
    </div>
</div>

    <!-- Background Video -->
    <video class="bg-video" autoplay muted loop>
        <source src="elements/video/back.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Login Form -->
    <div class="container">
        <div class="form-box">
            <div class="logo">
                <img src="elements/img/logo/logo.png" alt="Company Logo">
            </div>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <div class="login-link mt-3">
                <p>Don't have an account? <a href="register.php">Register Here</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>



