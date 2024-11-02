<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = ""; // Adjust if you have set a password for MySQL
$db_name = "businessdb"; // Make sure this database exists

$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
