<?php
// Database configuration
define('DB_SERVER', 'localhost');   // Database host (usually localhost)
define('DB_USERNAME', 'root');      // Database username
define('DB_PASSWORD', '');          // Database password
define('DB_NAME', 'appointment_system_updated'); // Database name

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "Connected successfully"; // Uncomment to check if the connection was successful
}
?>

