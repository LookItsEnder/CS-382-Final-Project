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
    <h1>Website Title - home Page</h1>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="canvas.php">Canvas</a>
        <a href="Gallery.php">Gallery</a>
        <a href="">Contact</a>
        
        <!-- Search Bar -->
        <form class="search-form" action="searchResults.html" method="GET">
            <input type="text" placeholder="Search..." name="search">
            <button type="submit">Search</button>
        </form>
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

      
</body>

</html>