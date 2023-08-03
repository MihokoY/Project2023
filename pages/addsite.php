<?php
// Start session processing
session_start();

//If the user is not logged in, redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header('Location: ../pages/login.php');
    exit;
}

// Cut out latitude and longitude from coordinate
$latitude_before = mb_strstr($_SESSION["coordinate"], "," , true); //Cut out the part before the comma
$latitude = substr($latitude_before, 7); //Cut out the 8th and subsequent characters 

$longitude_before = mb_strstr($_SESSION["coordinate"], "," , false); //Cut out the part after the comma
$longitude_before2 = substr($longitude_before, 2); //Cut out the 2nd and subsequent characters 
$longitude = rtrim($longitude_before2, ")"); //Remove last bracket
        
//Conneco to the database
require('dbconnect.php');

// When Add button is clicked
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
            // Insert the data into the sites table
            $stmt1 = $db->prepare("INSERT INTO sites(latitude, longitude, name, description, image, user_id, flg) VALUE(?, ?, ?, ?, ?, ?, ?)");
            $stmt1->execute([$latitude, $longitude, $_POST['sitename'], $_POST['description'], $filename, $_SESSION["user_id"], 1]);
        }else{
            $statusMsg = "File upload failed";
        }           
        echo $statusMsg;

    // Without image
    }else{
        // Insert the data into the sites table
        $stmt2 = $db->prepare("INSERT INTO sites(latitude, longitude, name, description, user_id, flg) value(?, ?, ?, ?, ?, ?)");
        $stmt2->execute([$latitude, $longitude, $_POST['sitename'], $_POST['description'], $_SESSION["user_id"], 1]);
    }

    // Move to addsite_complete page
    header('Location: addsite_complete.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add new site</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
              crossorigin="anonymous">  
        <link rel="stylesheet" href="../css/external.css">
        <link rel="stylesheet" href="../css/external_footer.css">
    </head>
    <body>
        <!-- Top menu -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand title" href="#">Archaeological map in Ireland</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/map.php">Explore map</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/mymap.php">My map</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/mysites.php">My sites</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/logout.php">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white">&#128100;<?php echo $_SESSION["user_name"]; ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Add new site form -->
        <div class="container mt-3">
            <h2>Add new site</h2>
            <form id="additionForm" name="additionForm" action=""  method="POST" enctype="multipart/form-data">           
                <div class="mb-3">
                    <label for="coordinate" class="form-label">Coordinate</label>
                    <p><b>Latitude: <?php echo htmlspecialchars($latitude, ENT_QUOTES);?>, Longitude: <?php echo htmlspecialchars($longitude, ENT_QUOTES);?></b></p>
                </div>
                <div class="mb-3">
                    <label for="sitename" class="form-label">Site name</label>
                    <input type="text" class="form-control" id="sitename" name="sitename" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <input type="file" name="upload_image">
                    <!-- If there is an error, show the error -->
                    <?php if (!empty($_FILES['upload_image']['error'])): ?>
                        <p class="error" style="color:red"><?php $_FILES['upload_image']['error']?></p>
                    <?php endif ?>
                </div>
                <button type="submit" id="add" name="add" class="btn btn-success">Add</button>
                <input type="reset" value="Reset" name="reset" class="btn btn-success">
                <input type="button" value="Back" name="back" class="btn btn-success" onclick="location.href='../pages/map.php'">
            </form>
        </div>

        <!-- Footer -->
        <footer class="footer bg-dark">
            <div class="container text-center mt-1">
                <p class="text-white title">©2023 Archaeology club, Inc. All Rights Reserved</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
                crossorigin="anonymous"></script>
    </body>
</html>