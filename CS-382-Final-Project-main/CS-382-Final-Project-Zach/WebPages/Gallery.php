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
        return $result ? $result[0][0] : null; // Return null if no result
    }
    function getURL($sql, $db) {
        $statement = $db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result ? $result[0][0] : null; // Return null if no result
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
        <title>Art Gallery</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <!-- Title -->
        <div class = 'logo'>

            <img src="../assets/logo.png" alt="logo">
            <h1>WebSkribble - Gallary Page</h1>

        </div>

        <!-- Navigation Bar -->
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="canvas.php">Canvas</a>
            <a href="Gallery.php">Gallery</a>
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

        <!-- Featured Artworks Section -->
        <div class="featured">
            <h3>Check out some featured Artwork!</h3>
            <div class="featureContainer">
                <?php
                // Fetch the maximum ID in the `art` table
                $sql = "SELECT MAX(id) FROM art";
                $max = getMax($sql, $db);
                if ($max) {
                    // Generate random artwork IDs and display their images
                    $numbers = range(1, $max);
                    shuffle($numbers);
                    $count = 0;
                    foreach ($numbers as $id) {
                        $sql = "SELECT url FROM art WHERE id = $id";
                        $URL = getURL($sql, $db);

                        if ($URL) {
                            echo "<div class=\"piece\"><img src=\"../images/$URL\" height=\"100%\" width=\"100%\"></div>";
                            $count++;
                            if ($count == 5) break; // Display only 5 artworks
                        }
                    }
                    // Handle case where no valid artworks exist
                    if ($count === 0) {
                        echo "<p>No artworks found.</p>";
                    }
                } else {
                    // No artworks in the database
                    echo "<p>No artworks found.</p>";
                }
                ?>
            </div>
        </div>
        <div class="searchBar">
            <p>Enter an ID to look up:</p>
            <!-- Search Bar -->
            <form action="../php files/searchResults.php" method="GET">
                <input type="text" placeholder="Search..." name="search" required>
                <button type="submit">Search</button>
            </form>
        </div>
    </body>
</html>