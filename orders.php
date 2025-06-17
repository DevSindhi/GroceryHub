<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your orders.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all orders for the user
$sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .order-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .order-box h3 {
            margin-top: 0;
            color: #0066cc;
        }
        .order-box p {
            margin: 5px 0;
        }
        .back-button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .back-button:hover {
            background-color: #004d99;
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-button">← Back to Home</a>

    <h2>My Orders</h2>

    <?php if (count($orders) > 0): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-box">
                <h3>Order #<?php echo $order['id']; ?> | Date: <?php echo $order['order_date']; ?></h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                <p><strong>Total Price:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; color: #888;">You have no orders yet.</p>
    <?php endif; ?>
</body>
</html>
