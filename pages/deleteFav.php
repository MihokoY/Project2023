<?php
// Start session processing
session_start();

require('dbconnect.php');
$stmt = $db->prepare("DELETE FROM mymap WHERE user_id = ? AND site_id = ?");
$stmt->bindValue(1, $_SESSION["user_id"]);
$stmt->bindValue(2, $_SESSION["site_id"]);
$stmt->execute();

// Return to JavaScript
//$favData=array();
//while($row=$stmt->fetch(PDO::FETCH_ASSOC)){ // Get results in the array
//    $favData[]=array(
//        'id'=>$row['id']
//    );
//}

// Convert PHP array to JSON formatted data
//$json = json_encode($favData);

?>
