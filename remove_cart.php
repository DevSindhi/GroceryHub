<?php
session_start();
include 'db_connection.php'; // Ensure this file correctly connects to the database

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize input

    // Debugging: Check if the ID is received
    if (!$id) {
        die("Error: Invalid product ID.");
    }

    // Prepare the delete query
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = :id");

    // Bind the parameter using PDO's bindParam method
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        // Debugging: Check if rows were affected
        if ($stmt->rowCount() > 0) {
            header("Location: cart.php");
            exit();
        } else {
            echo "Error: Item not found in the cart.";
        }
    } else {
        echo "Error: Unable to remove item.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn = null; // Close the PDO connection
