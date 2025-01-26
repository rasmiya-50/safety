<?php
session_start(); // Start the session

// Dummy credentials for demonstration
$valid_username = "user";
$valid_password = "password";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials (in a real application, you would check against a database)
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['loggedin'] = true; // Set session variable
        header("Location: sos.php"); // Redirect to sos.php
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST" id="login-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
            
            <div class="error-message" id="error-message">
                <?php if (isset($error_message)) echo $error_message; ?>
            </div>
        </form>
        <p>Don't have an account? <a href="sos.html">Sign up</a></p>
    </div>
</body>
</html>