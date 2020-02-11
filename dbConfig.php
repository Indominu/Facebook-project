<?php
    // Database configuration
    $dbHost = "172.16.115.20";
    $dbUsername = "Highwook";
    $dbPassword = "Password1";
    $dbName = "HighWook";
    
    // Create database connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    
    // Check connection
    if ( $conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
