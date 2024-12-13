<!-- login_backend.php -->
<?php
session_start();
include('db.php'); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user data based on email
    $stmt = $conn->prepare("SELECT id, password, role FROM users2 WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php');
            } elseif ($user['role'] === 'seller') {
                header('Location: seller_dashboard.php');
            } else {
                header('Location: buyer_dashboard.php');
            }
            exit();
        } else {
            header('Location: login.php?error=Incorrect password');
            exit();
        }
    } else {
        header('Location: login.php?error=User not found');
        exit();
    }
}
?>
