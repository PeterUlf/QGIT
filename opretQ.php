<?php
session_start();
    include "../forbindelse.php";
$number =file_get_contents('counter.txt');
$number++;
file_put_contents('counter.txt',$number);
    
    unset($_SESSION["studerende"]); 
    unset($_SESSION["starttid"]);   


    // Create connection
     
    $sql="drop table ".$_SESSION["koenavn"];
    $forbindelse->query($sql); 
//echo "$sql<br>";
    // sql to create table
    $sql = "CREATE TABLE ".$_SESSION["koenavn"]." (
        deltagernummer INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        navn VARCHAR(30) NOT NULL,
        tidspunkt VARCHAR(50) NOT NULL
    )";
//echo "$sql<br>";
    $forbindelse->query($sql);


    $forbindelse->close(); 
header("Location: vejledning.php");
?>
