<?php
// Database connection settings
$host = 'localhost';        
$user = 'fhyath2';             
$pass = 'fhyath2';                 
$dbname = 'fhyath2';  

// Create a new MySQLi connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // Stop execution and display error message
    die("Connection failed: " . $conn->connect_error);
}
?>

