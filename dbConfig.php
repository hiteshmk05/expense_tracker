<?php 
    session_start();
    $dbHost     = "localhost"; 
    $dbUsername = "root"; 
    $dbPassword = ""; 
    $dbName     = "expense_tracker"; 
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error); 
    }
?>