<?php
// --- SECURE DATABASE CONNECTION ---

// Get the internal database URL from Render's environment variables
$db_url = getenv('DATABASE_URL');

if (empty($db_url)) {
    // If the DATABASE_URL is not set, the app will fail with a clear message.
    die("❌ Error: DATABASE_URL environment variable is not set. Please set it in your Render dashboard.");
}

// Parse the URL to get the connection details
// Parse the URL to get the connection details
$db_parts = parse_url($db_url);

$host = $db_parts['host'];
$port = $db_parts['port'] ?? 5432; // ✅ Use default if not provided
$dbname = ltrim($db_parts['path'], '/');
$user = $db_parts['user'];
$password = $db_parts['pass'];

// Build the DSN (Data Source Name) for PDO
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname};user={$user};password={$password}";


$pdo = null; // Initialize pdo variable
try {
    // Create a new PDO instance
    $pdo = new PDO($dsn);
    
    // Set PDO to throw exceptions on error, which is good practice
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // If the connection is successful, this line will be reached.
    // We can set a success message to display later.
    $connection_status = "✅ Successfully connected to the database!";
    
} catch (PDOException $e) {
    // If connection fails, set an error message
    // For debugging, you could log the error: error_log($e->getMessage());
    $connection_status = "❌ Error: Unable to connect to PostgreSQL database.";
}

// --- HTML AND PAGE CONTENT ---
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


