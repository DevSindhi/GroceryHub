<?php
session_start();

// Include PDO connection
include 'db_connection.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["full_name"], $_POST["email"], $_POST["username"], $_POST["password"])) {
        $error = "All fields are required!";
    } else {
        $full_name = trim($_POST["full_name"]);
        $email = trim($_POST["email"]);
        $username = trim($_POST["username"]);
        $password = $_POST["password"];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format!";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            try {
                // Check if email already exists
                $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
                $check_stmt->execute(['email' => $email]);

                if ($check_stmt->rowCount() > 0) {
                    $error = "Email is already registered. Please use a different email.";
                } else {
                    // Insert new user
                    $insert_stmt = $conn->prepare("INSERT INTO users (full_name, email, username, password) VALUES (:full_name, :email, :username, :password)");
                    $insert_result = $insert_stmt->execute([
                        'full_name' => $full_name,
                        'email' => $email,
                        'username' => $username,
                        'password' => $hashed_password
                    ]);

                    if ($insert_result) {
                        header("Location: login.php?message=success");
                        exit();
                    } else {
                        $error = "Error inserting user.";
                    }
                }
            } catch (PDOException $e) {
                $error = "Database error: " . htmlspecialchars($e->getMessage());
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - GroceryHub</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #d4edda, #a8e6cf);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 450px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-align: center;
            box-sizing: border-box;
        }
        h1 {
            color: #1e8449;
        }
        input, button {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
        }
        button {
            background: #1e8449;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #145a32;
        }
        .message {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>

        <?php if (!empty($error)): ?>
            <p class="message error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['message']) && $_GET['message'] === "success"): ?>
            <p class="success-message">Registration successful! <a href="login.php">Login here</a></p>
        <?php endif; ?>

        <form method="POST" action="register.php" novalidate>
            <input type="text" name="full_name" placeholder="Full Name" required autofocus />
            <input type="email" name="email" placeholder="Email" required />
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password (min 6 characters)" required />
            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
