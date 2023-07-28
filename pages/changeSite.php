<!--<script> alert('changeSite.php'); </script>-->
<?php
// Start session processing
session_start();
$postSiteId = $_POST['siteId'];

//Conneco to database
require('dbconnect.php');

// When the change button is clicked
if (!empty($_POST)) {
    // Blank check
    //if ($_POST['sitename'] === "") {
    //    $error['sitename'] = "blank";
    //}
    //if ($_POST['description'] === "") {
    //    $error['description'] = "blank";
    //}
  
    //if (!isset($error)) {
        // With image
        if(!empty($_FILES["upload_image"]["name"])){
            $statusMsg = '';
            //$allowTypes = array('jpg','png','jpeg','gif','pdf');
            $filename = basename($_FILES['upload_image']['name']);
            $uploadedPath = '../images/'.$filename;       
            //$filetype = pathinfo($uploadedPath, PATHINFO_EXTENSION);
            //if(in_array($allowTypes, $filetype)){
            
            if(move_uploaded_file($_FILES['upload_image']['tmp_name'], $uploadedPath)){
                // Set data into database
                $stmt1 = $db->prepare("UPDATE sites SET name = ?, description = ?, image = ? WHERE id = $postSiteId");
                $stmt1->execute([$_POST['sitename'], $_POST['description'], $filename]);
            }else{
                $statusMsg = "File upload failed";
            }
            echo $statusMsg;
            
        // Without image
        }else{
            // Set data into database
            $stmt2 = $db->prepare("UPDATE sites SET name = ?, description = ? WHERE id = $postSiteId");
            $stmt2->execute([$_POST['sitename'], $_POST['description']]);
        }
        
        // Show message
        //echo "<script>alert('Changed!');</script>";
        $_SESSION["fromChangeSite"] = true;
        
        // Move to mysites page
        header('Location: mysites.php');
        
        //exit();
    //}
}

?>
