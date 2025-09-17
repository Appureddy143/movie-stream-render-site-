<?php
// PostgreSQL connection string
$dsn = "pgsql:host=dpg-d33ubc7diees739skee0-a.oregon-postgres.render.com;port=5432;dbname=movie_streaming_d4xr;user=movie_streaming_d4xr_user;password=5z4fBfUcn5TRUiz19mkEKLZ8SlO515Yc";

try {
    // Create PDO instance
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $dob = $_POST['dob'];
    $avatar = trim($_POST['avatar']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Email is already registered!');</script>";
        echo "<script>window.location.href='register.php';</script>";
        exit;
    }

    // Insert new user
    $insert = $pdo->prepare("INSERT INTO users (username, email, dob, avatar, password) VALUES (:username, :email, :dob, :avatar, :password)");
    $success = $insert->execute([
        'username' => $username,
        'email' => $email,
        'dob' => $dob,
        'avatar' => $avatar,
        'password' => $password
    ]);

    if ($success) {
        echo "<script>alert('Registration successful!');</script>";
        echo "<script>window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error: Could not register.');</script>";
        echo "<script>window.location.href='register.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registration Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }
        .bg-video {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
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
            background: rgba(255, 255, 255, 0.49);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 350px;
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
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .avatar-option {
            width: 80px;
            height: 80px;
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 50%;
            transition: transform 0.3s, border-color 0.3s;
            margin: 5px;
        }
        .avatar-option:hover {
            transform: scale(1.1);
            border-color: #007bff;
        }
        .avatar-option.selected {
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <!-- Background Video -->
    <video class="bg-video" autoplay muted loop>
        <source src="elements/video/back.mp4" type="video/mp4" />
        Your browser does not support the video tag.
    </video>

    <!-- Registration Form -->
    <div class="container">
        <div class="form-box">
            <div class="logo">
                <img src="elements/img/logo/logo.png" alt="Company Logo" />
            </div>
            <form action="" method="POST" novalidate>
                <div class="mb-3">
                    <label for="username" class="form-label">User Name</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        placeholder="Enter your name"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter your email"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Select Avatar</label>
                    <input type="hidden" id="avatar" name="avatar" required />
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#avatarModal"
                    >
                        Choose Avatar
                    </button>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Create a password"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-success">Register</button>
            </form>
            <div class="login-link">
                <p>
                    Already have an account? <a href="login.php">Login Here</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Avatar Modal -->
    <div
        class="modal fade"
        id="avatarModal"
        tabindex="-1"
        aria-labelledby="avatarModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avatarModalLabel">Choose Your Avatar</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body text-center">
                    <img
                        src="elements/img/ava/avatar1.gif"
                        alt="Avatar 1"
                        class="avatar-option"
                        data-value="avatar1.gif"
                    />
                    <img
                        src="elements/img/ava/avatar2.gif"
                        alt="Avatar 2"
                        class="avatar-option"
                        data-value="avatar2.gif"
                    />
                    <img
                        src="elements/img/ava/avatar3.gif"
                        alt="Avatar 3"
                        class="avatar-option"
                        data-value="avatar3.gif"
                    />
                    <img
                        src="elements/img/ava/avatar4.gif"
                        alt="Avatar 4"
                        class="avatar-option"
                        data-value="avatar4.gif"
                    />
                    <img
                        src="elements/img/ava/avatar5.gif"
                        alt="Avatar 5"
                        class="avatar-option"
                        data-value="avatar5.gif"
                    />
                    <img
                        src="elements/img/ava/avatar6.gif"
                        alt="Avatar 6"
                        class="avatar-option"
                        data-value="avatar6.gif"
                    />
                    <img
                        src="elements/img/ava/avatar7.gif"
                        alt="Avatar 7"
                        class="avatar-option"
                        data-value="avatar7.gif"
                    />
                    <img
                        src="elements/img/ava/avatar8.gif"
                        alt="Avatar 8"
                        class="avatar-option"
                        data-value="avatar8.gif"
                    />
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const avatarOptions = document.querySelectorAll(".avatar-option");
            const avatarInput = document.getElementById("avatar");

            avatarOptions.forEach((option) => {
                option.addEventListener("click", () => {
                    // Deselect all avatars
                    avatarOptions.forEach((opt) =>
                        opt.classList.remove("selected")
                    );

                    // Select clicked avatar
                    option.classList.add("selected");

                    // Update hidden input
                    avatarInput.value = option.getAttribute("data-value");

                    // Close modal
                    const modal = document.getElementById("avatarModal");
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    modalInstance.hide();
                });
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
