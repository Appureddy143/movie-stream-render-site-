<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Infinity</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #1e1e1e;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        .navbar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .nav-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                flex-direction: column;
                background-color: #1e1e1e;
                padding: 15px;
                position: absolute;
                top: 60px;
                right: 20px;
                z-index: 1000;
                border: 1px solid #444;
                border-radius: 5px;
            }

            .nav-links.show {
                display: flex;
            }

            .nav-toggle {
                display: block;
            }
        }

        .about-section {
            padding: 50px 20px;
            text-align: center;
        }

        .about-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .about-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .team-section {
            background-color: #1e1e1e;
            padding: 50px 20px;
            text-align: center;
        }

        .team-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .team-section .team-members {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .team-member {
            background-color: #2a2a2a;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            width: 200px;
        }

        .team-member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #1e1e1e;
            color: white;
            margin-top: 20px;
        }

        #loading-screen {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #121212;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner-box {
            text-align: center;
        }

        .circle-border {
            border: 5px solid white;
            border-top: 5px solid transparent;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        .circle-core {
            width: 30px;
            height: 30px;
            background: white;
            border-radius: 50%;
            margin: auto;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
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

    <nav class="navbar">
        <a href="home.php" class="logo">Infinity</a>
        <button class="nav-toggle" onclick="toggleNav()">☰</button>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="profile.php">Profile</a>
            <a href="history.php">History</a>
            <a href="about.php">About</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="about-section">
        <h1>About Our Platform</h1>
        <p>
            Welcome to our movie streaming platform! Our goal is to bring you the latest movies from various genres and languages, 
            all in one place. Whether you love action, drama, or comedy, we have something for everyone. Enjoy seamless streaming 
            and downloading experiences, personalized recommendations, and more!
        </p>
    </div>

    <div class="team-section">
        <h2>Meet Our Team</h2>
        <div class="team-members">
            <div class="team-member">
                <img src="avatars/avatar1.png" alt="Team Member">
                <h5>John Doe</h5>
                <p>Founder & Developer</p>
            </div>
            <div class="team-member">
                <img src="avatars/avatar2.png" alt="Team Member">
                <h5>Jane Smith</h5>
                <p>UI/UX Designer</p>
            </div>
            <div class="team-member">
                <img src="avatars/avatar3.png" alt="Team Member">
                <h5>Emily Brown</h5>
                <p>Content Curator</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Infinity Entertainment. All Rights Reserved.</p>
    </div>

    <script>
        function toggleNav() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('show');
        }

        // Hide loading screen after the page loads
        window.addEventListener('load', () => {
            const loadingScreen = document.getElementById('loading-screen');
            loadingScreen.style.display = 'none';
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
