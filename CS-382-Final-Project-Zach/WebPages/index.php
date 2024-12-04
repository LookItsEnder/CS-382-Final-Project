<?php

session_start();


// Check if the user is logged in

$is_logged_in = isset($_SESSION ['user_id']);

$username = $is_logged_in ? $_SESSION ['username'] : null;

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Canvas Page</title>

    <link rel="stylesheet" href="../style.css">

</head>

<body>
    <!-- Title -->
    <div class = 'logo'>

    <img src="../assets/logo.png" alt="logo">
    <h1>WebSkribble - Home Page</h1>

    </div>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="canvas.php">Canvas</a>
        <a href="Gallery.php">Gallery</a>
        <a href="">Contact</a>
        
       
 <!-- Login/Register or User Info -->

    <div class="auth-buttons">

            <?php if ($is_logged_in): ?>

                <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>

                <a href="../php files/logout.php" class="button">Logout</a>

            <?php else: ?>

                <a href="../php files/login.php" class="button">Login</a>

                <a href="../php files/register.php" class="button">Register</a>

            <?php endif; ?>

    </div>
       
    </nav>


    <div class = "home-container">

        
        <h2>Welcome to the Art Website's Home Page!</h2>


        <p>We are thrilled to have you here! The goal of this website and our creative project is to provide a vibrant platform where art enthusiasts can unleash their creativity. Here, you can draw directly on the site using our intuitive tools or upload your unique artwork to share with others. Once uploaded, your creations will be proudly displayed in our gallery for everyone to admire and enjoy.</p>


        <p>Whether you're a seasoned artist, a budding creator, or simply someone who loves exploring the world of art, this is the perfect space to express yourself and connect with a community that values creativity. Dive in, let your imagination soar, and contribute to a growing collection of diverse and inspiring artwork!</p>


    </div>


      
</body>

</html>