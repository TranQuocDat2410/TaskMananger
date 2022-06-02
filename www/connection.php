<?php
    // header('Access-Control-Allow-Origin: *');
    $host = 'mysql-server';
    $dbName = 'tdt';
    $userName = 'root';
    $password = 'root';
    try{
        $dbCon = new PDO("mysql:host=".$host.";dbname=".$dbName, $userName, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $ex){
        die(json_encode(array('status' => false, 'data' => 'Unable to connect: ' . $ex->getMessage())));
    }
    
?>