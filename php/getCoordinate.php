<?php
// Start session processing
session_start();

// Receive POST data(coordinate
$raw = file_get_contents('php://input'); 
// Convert JSON format to PHP variable
$coordinate = json_decode($raw); 
// Stored in session information
$_SESSION["coordinate"] = $coordinate;
// Return to JavaScript
//echo json_encode($coordinate);

?>
