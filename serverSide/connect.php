<?php
    $user = 'root';
    $pass = ''; 
    $dsn='mysql:host=localhost; dbname=artworkdb';
    try {
        $db = new PDO($dsn, $user, $pass); //create a new PDO object instance
        //$dbname = $db->query('SELECT database()')->fetchColumn();
        //echo "Connected ".$dbname; 

    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br>";
        die();
    }
?>