<?php
    $connection = "mysql:host=localhost;dbname=store";
    $db_user = "root";
    $db_pass = "";
    
    try{
        $pdo = new PDO($connection, $db_user, $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //throw execeptions on errors
             
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // fetch assoc arrays by default
        ]
                      );
    }
    catch(PDOException $e){
        die("Could not connect to the database " . $e->getMessage());
    }

?>