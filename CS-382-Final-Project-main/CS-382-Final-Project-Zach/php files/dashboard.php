<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();

}


echo "Welcome to your dashboard!";

?>

<a href="logout.php">Logout</a>