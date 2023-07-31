<?php
// Start session processing
session_start();

// Connect to the database
require('dbconnect.php');
// Update the mymap table
$stmt = $db->prepare("DELETE FROM mymap WHERE user_id = ? AND site_id = ?");
$stmt->bindValue(1, $_SESSION["user_id"]);
$stmt->bindValue(2, $_SESSION["site_id"]);
$stmt->execute();

?>
