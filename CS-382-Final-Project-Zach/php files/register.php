<?php

// Database connection

$conn = new mysqli('localhost', 'root', '', 'login');

if ($conn -> connect_error) {
    die( "Connection failed: " . $conn -> connect_error);

}

if ($_SERVER ['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];

    $password = $_POST['password']; 


    $stmt = $conn -> prepare ("INSERT INTO users (username, password) VALUES (?, ?)");

    $stmt -> bind_param ('ss', $username, $password);


    if ($stmt -> execute()) {

        // Redirect to home page

        header("Location: ../WebPages/index.php");

        exit();

    } else {

        echo "Error: " . $stmt->error;
    }

}

?>

<link rel="stylesheet" href="../style.css">

<!-- Title -->
<div class = 'logo'>

    <img src="../assets/logo.png" alt="logo">
    <h1>WebSkribble - Register Page</h1>

</div>

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



<!-- Registration Form -->
<div class="login-form">

    <h2>Register</h2>

    <form method="POST" action="register.php">

        <label for="username">Username</label>

        <input type="text" id="username" name="username" placeholder="Choose a username" required>
        
        <label for="password">Password</label>

        <input type="password" id="password" name="password" placeholder="Create a password" required>
        
        <button type="submit">Register</button>
        
        <a href="login.php">Already have an account? Login here</a>
        
    </form>
</div>


