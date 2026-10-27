<?php
$host = "localhost";
$user = "root";
$password = ""; // Default XAMPP password is empty
$database = "school_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>