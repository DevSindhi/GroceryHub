<?php
try {
    $conn = new PDO("pgsql:host=localhost;port=5432;dbname=grocery_db", "postgres", "postgres");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
