<?php
session_start();

// Receive coordinate value
$raw = file_get_contents('php://input'); // Receive POST data
$coordinate = json_decode($raw); // Convert JSON format to PHP variable
// Stored in session information
$_SESSION["coordinate"] = $coordinate;
// Return to JavaScript
//echo json_encode($coordinate);

?>
