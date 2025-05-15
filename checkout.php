<?php
session_start();
include 'db_connection.php'; // Database connection

// Ensure the user is logged in before proceeding
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to place an order.";
    exit;
}

// Fetch the user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch cart items and calculate the total price
$sql = "SELECT * FROM cart WHERE user_id = :user_id"; // Fetch cart items of the logged-in user
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_price = 0;

// Calculate total price
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Check if the form is submitted
$order_placed = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $payment = $_POST['payment_method'];

    // Insert the order into the database with the user_id
    $insert_order = $conn->prepare("INSERT INTO orders (user_id, name, address, payment_method, total_price) VALUES (?, ?, ?, ?, ?)");
    $insert_order->bindParam(1, $user_id, PDO::PARAM_INT); // Binding user_id
    $insert_order->bindParam(2, $name, PDO::PARAM_STR);
    $insert_order->bindParam(3, $address, PDO::PARAM_STR);
    $insert_order->bindParam(4, $payment, PDO::PARAM_STR);
    $insert_order->bindParam(5, $total_price, PDO::PARAM_STR);

    // Execute the order insertion
    if ($insert_order->execute()) {
        $order_placed = true;
        // Clear the cart only after successful order placement
        $conn->prepare("DELETE FROM cart WHERE user_id = :user_id")->execute([':user_id' => $user_id]);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your same styles remain unchanged */
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f9f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            margin-top: 30px;
        }
        h2 { color: #27ae60; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        .checkout-form input, .checkout-form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            background: #f39c12;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 400px;
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .modal button {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            font-size: 1.1em;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .modal button:hover {
            background: #219150;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Checkout</h2>
    <h3>Order Summary</h3>
    <table>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
        <?php foreach ($cart_items as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td>₹<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h3>Total: ₹<?php echo number_format($total_price, 2); ?></h3>

    <h3>Billing Details</h3>
    <form method="POST" class="checkout-form">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="text" name="address" placeholder="Full Address" required>
        <select name="payment_method">
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Card Payment">Card Payment</option>
        </select>
        <button type="submit" class="btn">Place Order</button>
    </form>
</div>

<?php if ($order_placed): ?>
    <div id="orderSuccessModal" class="modal" style="display: flex;">
        <div class="modal-content">
            <h2>🎉 Order Placed Successfully! </h2>
            <p>Thank you for shopping with us. Your order has been placed successfully.</p>
            <button onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
