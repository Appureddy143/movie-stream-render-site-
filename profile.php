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

// Session Start
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch User Info
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$user = $conn->query($query)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Infinity</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .info {
            text-align: center;
            margin-bottom: 20px;
        }

        .info .field {
            margin: 10px 0;
            font-size: 18px;
        }

        .logout-btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #d9534f;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c9302c;
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

    <div class="profile-container">
        <img src="elements/img/ava/<?php echo $user['avatar']; ?>" alt="Avatar" class="avatar">
        <div class="info">
            <div class="field"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></div>
            <div class="field"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></div>
            <div class="field"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></div>
            <div class="field"><strong>Password:</strong> ********</div>
        </div>
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
