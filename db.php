<?php
$servername = "localhost";
$username = "jphan14";
$password = "jphan14";
$dbname = "jphan14";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>