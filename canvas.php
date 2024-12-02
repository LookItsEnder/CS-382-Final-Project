<?php
    include_once("serverSide/connect.php");
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Canvas Page</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js"></script> 
        <link rel="stylesheet" href="CanvasJs/style.css" >
    </head>
    <body>
        <!-- Title -->
        <h1> Website Title - Canvas page</h1>
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
    </nav>
        <!--This allows for separation between the two color circles, and the canvas-->
        <div class="box">
            <div class="color-pallet2" id="secondary"></div>
            <div class="color-pallet" id="primary"></div>
            <div><p>Controls:</p>
            <ul><li>Shift S: Saves your work to your computer</li>
                <li>Ctrl Z: Undo | Ctrl Shift Z: Redo</li>
                <li>X: Swaps color pallets</li>
                <li>B: Brush Tool ([ to shrink, ] to grow)</li>
                <li>I: Eyedropper Tool</li>
                <li>S: Clonestamp Tool -> Ctrl Left click to take an area.</li>
                <li>E: Eraser Tool</li></ul></div>
            <p>If theres an artwork you would like to upload, you can do so here:</p>
        <form method="POST" action="" enctype="multipart/form-data">
                <input class="form-control" type="file" name="uploadfile" value="" />
                <button class="btn btn-primary" type="submit" name="upload">Upload to the Website!</button>
        </form>
        </div>
        <div id="canvasDiv"><script  src="CanvasJs/Canvas.js"></script></div>
    </body>
</html>