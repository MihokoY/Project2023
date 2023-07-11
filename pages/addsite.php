<?php
session_start();

//If the user is not logged in, redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../pages/login.php");
    exit;
}

// Cut latitude and longitude from coordinate
$latitude_before = mb_strstr($_SESSION["coordinate"], "," , true); //Cut out the part before the comma
$latitude = substr($latitude_before, 7); //Cut out the 8th and subsequent characters 

$longitude_before = mb_strstr($_SESSION["coordinate"], "," , false); //Cut out the part after the comma
$longitude_before2 = substr($longitude_before, 2); //Cut out the 2nd and subsequent characters 
$longitude = rtrim($longitude_before2, ")"); //Remove last bracket
        
//Conneco to database
require('dbconnect.php');

if (!empty($_POST)) {
    // Blank check
    if ($_POST['sitename'] === "") {
        $error['sitename'] = "blank";
    }
    if ($_POST['description'] === "") {
        $error['description'] = "blank";
    }

    // Image
    if(!empty($_FILES)){
        $filename = $_FILES['upload_image']['name'];
        $uploaded_path = '../images/'.$filename;
        $result = move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);

    }
    
    if (!isset($error)) {
        // Set data into database
        $stmt = $db->prepare("insert into sites(latitude, longitude, name, description, image, user_id) value(?, ?, ?, ?, ?)");
        $stmt->execute($latitude, $longitude, $_POST['sitename'], $_POST['description'], $filename, $_SESSION["id"]);

        // Move to addsite_complete page
        header('Location: addsite_complete.php');
        exit();
    }
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
    <!--<link rel="stylesheet" href="../css/bootstrap.min.css">-->
    <link rel="stylesheet" href="../css/external.css">
</head>
<body>
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
                        <a class="nav-link" href="../pages/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <h2 class="login_h2">Add new site</h2>
        <form id="additionForm" name="additionForm" action=""  method="POST" enctype="multipart/form-data">           
            <div class="mb-3">
                <label for="coordinate" class="form-label">Coordinate</label>
                <!--<p><b>Coordinate: <?php echo htmlspecialchars($_SESSION["coordinate"], ENT_QUOTES);?></b></p>-->
                <p><b>Latitude: <?php echo htmlspecialchars($latitude, ENT_QUOTES);?>, Longitude: <?php echo htmlspecialchars($longitude, ENT_QUOTES);?></b></p>
            </div>
            <div class="mb-3">
                <label for="sitename" class="form-label">Site name</label>
                <input type="text" class="form-control" id="sitename" name="sitename">
                <?php if (!empty($error["sitename"]) && $error['sitename'] === 'blank'): ?>
                    <p class="error" style="color:red">*Please enter the site name.</p>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                <?php if (!empty($error["description"]) && $error['description'] === 'blank'): ?>
                    <p class="error" style="color:red">*Please enter the description.</p>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <input type="file" name="upload_image">
                <?php if (!empty($_FILES['upload_image']['error'])): ?>
                    <p class="error" style="color:red"><?php $_FILES['upload_image']['error']?></p>
                <?php endif ?>
            </div>
            <button type="submit" id="add" name="add" class="btn btn-primary">Add</button>
            <input type="reset" value="Reset" name="reset" class="btn btn-primary">
            <input type="button" value="Back" name="back" class="btn btn-primary" onclick="location.href='../pages/map.php'">
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
            crossorigin="anonymous"></script>
</body>
</html>