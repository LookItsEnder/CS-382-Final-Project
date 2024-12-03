<?php
session_start();

// Database Connection
include_once("../php files/connect.php");
if (!$db) {
    echo "Could not connect to the database";
    exit();
}

// Utility Functions
function getMax($sql, $db) {
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result[0][0];
}

function getURL($sql, $db) {
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result[0][0];
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="CanvasJs/style.css">
    
</head>
<body>
    <!-- Title -->
    <h1>Website Title - Home Page</h1>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="canvas.php">Canvas</a>
        <a href="#">Gallery</a>
        <a href="#">About</a>

        <!-- Search Bar -->
        <form class="search-form" action="searchResults.html" method="GET">
            <input type="text" placeholder="Search..." name="search">
            <button type="submit">Search</button>
        </form>

        <!-- Login/Register or User Info -->
        <div class="auth-buttons">
            <?php if ($is_logged_in): ?>
                <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
                <a href="logout.php" class="button">Logout</a>
            <?php else: ?>
                <a href="login.php" class="button">Login</a>
                <a href="register.php" class="button">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Featured Artworks Section -->
    <div class="featured">

        <h3>Check out some featured Artwork!</h3>

        <div class="featureContainer">
            <?php
            // Fetch and display 5 random artworks

            $sql = "SELECT id FROM art WHERE id = (SELECT max(id) FROM art)";

            $max = getMax($sql, $db);


            if ($max) {

                $numbers = range(1, $max);

                shuffle($numbers);

                for ($i = 0; $i < 5; $i++) {

                    $URL = "images/";

                    $sql = "SELECT url FROM art WHERE id = $numbers[$i]";

                    $URL .= getURL($sql, $db);

                    echo "<div class=\"piece\"><img src=\"$URL\" height=\"100%\" width=\"100%\"></div>";

                }
            } else {

                echo "<p>No artworks found.</p>";

            }

            ?>

        </div>

        
</body>

</html>
