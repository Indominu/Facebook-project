<?php
    // Database configuration
    $dbHost     = "anightabovethemall.com.mysql.service.one.com";
    $dbUsername = "anightabovethemall_comhighbook";
    $dbPassword = "Password1";
    $dbName     = "anightabovethemall_comhighbook";
    
    // Create database connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    
    // Check connection
    if ( $conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>