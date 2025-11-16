<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "auth";
$conn = "";

try {
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
} catch (mysqli_sql_exception $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>