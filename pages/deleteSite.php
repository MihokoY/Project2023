<?php
// Start session processing
session_start();

// Receive site ID value
$raw = file_get_contents('php://input'); // Receive POST data
$siteId = json_decode($raw); // Convert JSON format to PHP variable

// Delete the site from sites table
require('dbconnect.php');
$stmt = $db->prepare("DELETE FROM sites WHERE id = ?");
$stmt->bindValue(1, $siteId);
$stmt->execute();

// Return to JavaScript
//$favData=array();
//while($row=$stmt->fetch(PDO::FETCH_ASSOC)){ // Get results in the array
//    $favData[]=array(
//        'id'=>$row['id']
//    );
//}

// Convert PHP array to JSON formatted data
//$json = json_encode($siteID);

?>
