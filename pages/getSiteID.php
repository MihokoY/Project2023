<?php
session_start();

// Receive coordinate value
$raw = file_get_contents('php://input'); // Receive POST data
$siteId = json_decode($raw); // Convert JSON format to PHP variable
// Stored in session information
$_SESSION["site_id"] = $siteId;
// Return to JavaScript
echo json_encode($_SESSION["site_id"]);

?>
