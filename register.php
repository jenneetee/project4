<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = $conn->real_escape_string($_POST['user_type']);
    $card_number = isset($_POST['card_number']) ? $conn->real_escape_string($_POST['card_number']) : null;
    $card_name = isset($_POST['card_name']) ? $conn->real_escape_string($_POST['card_name']) : null;
    $expiration_date = isset($_POST['expiration_date']) ? $conn->real_escape_string($_POST['expiration_date']) : null;
    $billing_address = isset($_POST['billing_address']) ? $conn->real_escape_string($_POST['billing_address']) : null;
    $phone_number = isset($_POST['phone_number']) ? $conn->real_escape_string($_POST['phone_number']) : null;

    $sql = "INSERT INTO users (first_name, last_name, email, username, password, user_type, card_number, card_name, expiration_date, billing_address, phone_number) 
            VALUES ('$first_name', '$last_name', '$email', '$username', '$password', '$user_type', '$card_number', '$card_name', '$expiration_date', '$billing_address', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to login.php after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
