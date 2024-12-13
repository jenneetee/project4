<!-- register.php -->
<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users2 (email, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $email, $hashed_password, $role);
    $stmt->execute();

    echo "Registration successful! <a href='login.php'>Login here</a>";
}
?>

<form action="register.php" method="POST">
    <label for="email">Email/Username:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="role">Role:</label>
    <select name="role" id="role">
        <option value="buyer">Buyer</option>
        <option value="seller">Seller</option>
        <option value="admin">Admin</option>
    </select>
    <br>
    <button type="submit">Register</button>
</form>