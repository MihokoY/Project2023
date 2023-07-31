<?php
// Start session processing
session_start();

// Receive POST data(site ID)
$raw = file_get_contents('php://input');
// Convert JSON format to PHP variable
$siteId = json_decode($raw);
// Stored in session information
$_SESSION["site_id"] = $siteId;
// Return to JavaScript
//echo json_encode($_SESSION["site_id"]);

?>
