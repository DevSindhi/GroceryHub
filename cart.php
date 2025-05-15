<?php
session_start();
include 'db_connection.php'; // Ensure database connection

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your cart.";
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM cart WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <style>
        /* Same styling as you already have */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f9f4;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #27ae60;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-remove {
            background: #e74c3c;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .checkout-btn {
            background: #f39c12;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            margin: 20px auto;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            display: block;
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Shopping Cart</h2>

        <?php if (count($items) > 0): ?>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo (int) $item['quantity']; ?></td>
                        <td>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <form action="remove_cart.php" method="post" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="btn btn-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php $total_price += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
            </table>

            <h3>Total: ₹<?php echo number_format($total_price, 2); ?></h3>
            <button class="checkout-btn" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
        <?php else: ?>
            <p>Your cart is empty. <a href="index.php">Continue Shopping</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
