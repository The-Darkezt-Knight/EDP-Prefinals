<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "auth";

try {
    $dsn = "mysql:host=$hostname;dbname=$database;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connected successfully!";
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>