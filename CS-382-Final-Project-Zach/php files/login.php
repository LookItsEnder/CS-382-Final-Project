
<?php
session_start(); // Start the session

// Database connection

$conn = new mysqli('localhost', 'root', '', 'login');


if ($conn-> connect_error ) {

    die("Connection failed: " . $conn-> connect_error );

}

$error = ''; // To store login error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];

    $password = $_POST['password'];


    // Prepared statement to fetch user details

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");

    $stmt->bind_param('s', $username);

    $stmt->execute();

    $stmt->store_result();


    if ($stmt->num_rows > 0) {

        $stmt->bind_result($id, $stored_password);

        $stmt->fetch();


        if ($password === $stored_password) {

            // Successful login

            $_SESSION['user_id'] = $id;

            $_SESSION['username'] = $username;


            header("Location: ../WebPages/index.php");

            exit();

        } else {

            $error = "Invalid password.";
        }
    } else {

        $error = "No user found with that username.";
    }


    $stmt->close();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>




<body>
    <!-- Title -->

    <h1>Website Title - Login Page</h1>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="../WebPages/index.php">Home</a>
        <a href="../WebPages/canvas.php">Canvas</a>
        <a href="../WebPages/Gallery.php">Gallery</a>
        <a href="#">Contact</a>

        <!-- Login and Register Buttons -->
        <div class="auth-buttons">
            <a href="../php files/login.php" class="button">Login</a>
            <a href="../php files/register.php" class="button">Register</a>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="login-form">
        <h2>Login</h2>

        <!-- Display error message, if any -->
        <?php if (!empty($error)): ?>

            
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
            <a href="register.php">Don't have an account? Register here</a>
        </form>
    </div>
</body>
</html>
