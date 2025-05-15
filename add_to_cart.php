<?php
session_start();
include 'db_connection.php'; // PostgreSQL connection file

header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!$conn) {
    echo json_encode(["error" => "Database connection failed!"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request method!"]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Please log in to add items to the cart."]);
    exit;
}

if (!isset($_POST['name'], $_POST['price'], $_POST['quantity'])) {
    echo json_encode(["error" => "Missing data!"]);
    exit;
}

$name = trim($_POST['name']);
$price = (float) $_POST['price'];
$quantity = (int) $_POST['quantity'];
$user_id = $_SESSION['user_id'];

if ($quantity <= 0) {
    echo json_encode(["error" => "Invalid quantity!"]);
    exit;
}

try {
    // Check if item already exists in cart
    $checkQuery = "SELECT id, quantity FROM cart WHERE user_id = :user_id AND name = :name";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Update quantity
        $newQuantity = $existing['quantity'] + $quantity;
        $updateQuery = "UPDATE cart SET quantity = :quantity WHERE id = :id";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
        $stmt->bindParam(':id', $existing['id'], PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(["success" => "Quantity updated in cart."]);
    } else {
        // Insert new item
        $insertQuery = "INSERT INTO cart (user_id, name, price, quantity) VALUES (:user_id, :name, :price, :quantity)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(["success" => "Item added to cart."]);
    }

} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
