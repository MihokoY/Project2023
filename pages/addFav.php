<?php
// Start session processing
session_start();

require('dbconnect.php');
$stmt = $db->prepare("INSERT INTO mymap (user_id, site_id) VALUE (?, ?)");
$stmt->bindValue(1, $_SESSION["user_id"]);
$stmt->bindValue(2, $_SESSION["site_id"]);
$stmt->execute();

// Return to JavaScript
//$favData=array();
//while($row=$stmt->fetch(PDO::FETCH_ASSOC)){ // Get results in the array
//    $favData[]=array(
//        'user_id'=>$row['user_id'],
//        'site_id'=>$row['site_id']
//    );
//}

// Convert PHP array to JSON formatted data
//$json = json_encode($favData);

?>
