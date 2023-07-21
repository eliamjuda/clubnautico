<?php
    //Change the port that you need
    $server = "localhost:3306";
    $user = "root";
    $password = "";
    $database = "clubnautico";

    try {

        $conn = new PDO("mysql:host=$server;dbname=$database", $user, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    } catch ( PDOException $e ){
        die($e -> getMessage());
    }

?>