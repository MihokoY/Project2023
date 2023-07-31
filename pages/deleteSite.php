<?php
// Start session processing
session_start();

// Receive POST data(site ID)
$raw = file_get_contents('php://input');
// Convert JSON format to PHP variable
$siteId = json_decode($raw); 

// Connect to the database
require('dbconnect.php');
// Delete the site from the sites table
$stmt = $db->prepare("DELETE FROM sites WHERE id = ?");
$stmt->bindValue(1, $siteId);
$stmt->execute();

?>
