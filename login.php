<?php
session_start();

// Include your PDO database connection
include 'db_connection.php';

$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    try {
        // Prepare SQL with named parameter
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify the password hash
            if (password_verify($password, $user["password"])) {
                // Set session variables
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["full_name"]; // adjust field name if needed

                // Redirect to homepage
                header("Location: index.php");
                exit();
            } else {
                $error = "❌ Invalid email or password.";
            }
        } else {
            $error = "❌ User not found. Please register first.";
        }
    } catch (PDOException $e) {
        $error = "❌ Database error: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - GroceryHub</title>
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
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-align: center;
        }
        h1 {
            color: #1e8449;
        }
        input, button {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            font-size: 16px;
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .success-message a {
            color: blue;
            text-decoration: none;
            font-weight: bold;
        }
        .success-message a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <!-- Success message after registration -->
        <?php if (isset($_GET['message']) && $_GET['message'] === "success"): ?>
            <p class="success-message">✔️ Registration successful! <a href="login.php">Login here</a></p>
        <?php endif; ?>

        <!-- Show error if exists -->
        <?php if (!empty($error)): ?>
            <p class="message error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php" novalidate>
            <input type="email" name="email" placeholder="Email" required autofocus />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
</body>
</html>
