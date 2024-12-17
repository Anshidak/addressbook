
<?php
// Database connection details
$host = "localhost";
$dbname = "test";
$username = "root";
$password = "";

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>
