<?php
// Start session processing
session_start();

// Get the hidden value(site ID, flag)
$postSiteId = $_POST['postData'][0];
$postFlag = $_POST['postData'][1];

// Connect to the database
require('dbconnect.php');
// Update the flg in the sites table
if($postFlag === "1"){
    $stmt = $db->prepare("UPDATE sites SET flg = 0 WHERE id = $postSiteId");
}else{
    $stmt = $db->prepare("UPDATE sites SET flg = 1 WHERE id = $postSiteId");
}
$stmt->execute();

// Move to Manage sites page
header('Location: managesites.php');
exit();

?>
