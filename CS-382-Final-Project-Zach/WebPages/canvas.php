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
    <div class = 'logo'>

        <img src="../assets/logo.png" alt="logo">
        <h1>WebSkribble - Canvas Page</h1>

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

    <div class="toolbarTop">
        <!-- for canvas -->
    </div>
    <div class="box">
        <div class="color-pallet2" id="secondary"></div>
        <div class="color-pallet" id="primary"></div>

        <div class="brush-icon" id="brush">
            <button id="brushButton">
                <img src="../assets/brush.png">
            </button>
        </div>

        <div class="eraser-icon" id="eraser">
            <button id="eraserButton">
                <img src="../assets/eraser.png">
            </button>
        </div>

        <div class="eyedropper-icon" id="eyedropper">
            <button id="eyedropperButton">
                <img src="../assets/eyedropper.png">
            </button>
        </div>

        <div class="stamp-icon" id="stamp">
            <button id="stampButton">
                <img src="../assets/stamp.png">
            </button>
        </div>
    </div>

  






    <div class="toolbarBot">
        <!-- for canvas -->
    </div>

    <div class="box">
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
   


    <script src="../JavaScript/Canvas.js"></script>
</body>

</html>
