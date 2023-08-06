<?php
// Start session processing
session_start();

// Get the hidden value(site ID)
$postSiteId = $_POST['siteId'];

//Conneco to the database
require('../php/dbconnect.php');

// When the change button is clicked, then OK button clicked
if (!empty($_POST)) {

    // With image
    if(!empty($_FILES["upload_image"]["name"])){
        $statusMsg = '';
        // Get the file name
        $filename = basename($_FILES['upload_image']['name']);
        // Path of the destination folder
        $uploadedPath = '../images/'.$filename;       

        // Move the image to the destination folder
        if(move_uploaded_file($_FILES['upload_image']['tmp_name'], $uploadedPath)){
            // Update the data into the sites table
            $stmt1 = $db->prepare("UPDATE sites SET name = ?, description = ?, image = ? WHERE id = $postSiteId");
            $stmt1->execute([$_POST['sitename'], $_POST['description'], $filename]);
        }else{
            $statusMsg = "File upload failed";
        }
        echo $statusMsg;

    // Without image
    }else{
        // Update the data into the sites table
        $stmt2 = $db->prepare("UPDATE sites SET name = ?, description = ? WHERE id = $postSiteId");
        $stmt2->execute([$_POST['sitename'], $_POST['description']]);
    }

    // Move to mysites page
    header('Location: ../pages/mysites.php');
    exit();
}

?>
