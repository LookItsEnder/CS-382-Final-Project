<?php
    include_once("../php files/connect.php");
    if (!$db) {
        echo "Could not connect to the database";
        exit();
    }
    //Get info from search
    if(isset($_GET['search'])){
        $search = $_GET['search'];
    }
    //Run SQL Query to gather the image for ID = search
    function searchImage($sql, $db){
        $statement = $db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result ? $result[0][0] : null; // Return null if no result
    }

    $sql = "SELECT url FROM `art` WHERE id = $search";
    $result = searchImage($sql,$db);
    session_start();
    // Check if the user is logged in
    $is_logged_in = isset($_SESSION['user_id']);
    $username = $is_logged_in ? $_SESSION['username'] : null;    
?>


<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Result for your Search</title>
        <link rel="stylesheet" href="../JavaScript/style.css">
    </head>
    <body>
        <!-- Title -->
        <div class = 'logo'>

            <img src="../assets/logo.png" alt="logo">
            <h1>WebSkribble - Gallary Art Search</h1>

        </div>

        <!-- Navigation Bar -->
        <nav class="navbar">
            <a href="../WebPages/index.php">Home</a>
            <a href="../WebPages/canvas.php">Canvas</a>
            <a href="../WebPages/Gallery.php">Gallery</a>
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

        <div>
            <?php
                //if query is empty, show error and ask to try again
                if($result == null){echo "<p><b>Image Not Found!</b></p>";}
                //else show image
                else{
                    echo"<h1>This is Artwork Entry $search!</h1>";
                    echo"<img src=\"../images/$result\" height=\"25%\" width=\"25%\">";
                }
            ?>
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