<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <!-- Login Form -->
        <form action="login_backend.php" method="POST">
            <!-- Email Field -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <!-- Password Field -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <!-- Submit Button -->
            <button type="submit">Login</button>
        </form>

        <!-- Error message if login fails -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <!-- Link to Register -->
        <a href="register.html">Don't have an account? Register here</a>
    </div>
</body>
</html>