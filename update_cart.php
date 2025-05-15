<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grocery_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    $sql = "UPDATE cart SET quantity='$quantity' WHERE id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: cart.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
