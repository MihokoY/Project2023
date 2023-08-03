<?php
// Start session processing
session_start();

// Get the hidden value(site ID, flag)
$postSiteId = $_POST['postData'][0];
$postFlag = $_POST['postData'][1];

// Connect to the database
require('../php/dbconnect.php');
// Update the flg in the member table
if($postFlag === "1"){
    $stmt = $db->prepare("UPDATE member SET flg = 0 WHERE id = $postSiteId");
}else{
    $stmt = $db->prepare("UPDATE member SET flg = 1 WHERE id = $postSiteId");
}
$stmt->execute();

// Move to Manage members page
header('Location: ../pages/managemembers.php');
exit();

?>
