<?php
// Start session processing
session_start();

// Connect to the database
require('dbconnect.php');
// Update the mymap table
$stmt = $db->prepare("INSERT INTO mymap (user_id, site_id) VALUE (?, ?)");
$stmt->bindValue(1, $_SESSION["user_id"]);
$stmt->bindValue(2, $_SESSION["site_id"]);
$stmt->execute();

?>
