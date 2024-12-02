<?php
    //Connect to MYSQL Server
    include_once("serverSide/connect.php");
    if(!$db){
        echo "Could not connect to the database";
        exit();
    }
    function getMax($sql, $db){
        $statement = $db->prepare($sql);
        $statement->execute(null);
        $result = $statement->fetchAll();
        return $result[0][0];
    }
    function getURL($sql, $db){
        $statement = $db->prepare($sql);
        $statement->execute(null);
        $result = $statement->fetchAll();
        return $result[0][0];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
        <!--Zach-->
        <link rel="stylesheet" href="CanvasJs/style.css" >
    </head>
    <body>
        <!-- Title -->
        <h1> Website Title - Home page</h1>
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
    </nav>
        <div class="featured">
            <h3>Check out some featured Artwork!</h3>
            <div class = featureContainer>
            <?php
                //Script to put 5 random artworks into the page
                $sql = "SELECT id FROM art WHERE id=(SELECT max(id) FROM art)";
                $max = getMax($sql, $db);
                //echo "<p>Max = $max</p>";
                //Get 5 random numbers, range 1 - max of ID in DB
                $numbers = range(1, $max);
                shuffle($numbers);
                for($i = 0; $i < 5; $i++){
                    $URL = "images/";
                    //echo "$numbers[$i]";
                    $sql = "SELECT url FROM art WHERE id = $numbers[$i]";
                    $URL.=getURL($sql, $db);
                    //echo "<p>$URL</p>";
                    echo "<div class=\"piece\"><img src=\"$URL\" height=\"100%\" width=\"100%\"></div>"; //<-- Auto H and W somehow.
                }
            ?>
        </div>
        </div>
    </body>
</html>