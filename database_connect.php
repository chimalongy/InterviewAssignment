<?php
// THIS MODULE MAINTAINS THE DATABASE CONNECTION

$host = 'localhost';                                // MySQL host
$dbname = 'interviewassignment';                    // Database name
$username = 'root';                                 // Database username
$password = '';                                     // Database password

// Create a connection to MySQL database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
