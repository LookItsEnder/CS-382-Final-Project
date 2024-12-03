<?php

session_start();




    include_once("../php files/connect.php");
    if(!$db){
        echo "Could not connect to the database";
        exit();
    }
    if(isset($_POST['upload'])){
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "./images/" . $filename;
        $sql = "INSERT INTO art (url) VALUES ('$filename')";
        $statement = $db->prepare($sql);
        $statement->execute(null);
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>&nbsp; Image uploaded successfully!</h3>";
        } else {
            echo "<h3>&nbsp; Failed to upload image!</h3>";
        }
    }



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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js"></script>

    <link rel="stylesheet" href="../style.css">

</head>

<body>
    <!-- Title -->
    <h1>Website Title - Canvas Page</h1>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="canvas.php">Canvas</a>
        <a href="">About</a>
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

        <div class="box">

            <div class="color-pallet2" id="secondary"></div>
            <div class="color-pallet" id="primary"></div>

        </div>



   


    <script src="../JavaScript/Canvas.js"></script>
</body>

</html>
