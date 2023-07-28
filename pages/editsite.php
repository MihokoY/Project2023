<?php
// Start session processing
session_start();
//echo $_POST['siteId'];
$postSiteId = $_POST['siteId'];

//If the user is not logged in, redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header('Location: ../pages/login.php');
    exit;
}
        
//Conneco to database
require('dbconnect.php');
$stmt = $db->prepare("SELECT * FROM sites WHERE id = ?");
$stmt->bindValue(1, $postSiteId);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit site</title>
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
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-3">
            <h2>Edit site</h2>
            <form id="changeForm" name="changeForm" action="changeSite.php" onsubmit="return onChangeButtonClick()" method="POST" enctype="multipart/form-data">           
                <div class="mb-3">
                    <label for="coordinate" class="form-label">Coordinate</label>
                    <!--<p><b>Coordinate: <?php echo htmlspecialchars($_SESSION["coordinate"], ENT_QUOTES);?></b></p>-->
                    <p><b>Latitude: <?php echo $row['latitude']; ?>, Longitude: <?php echo $row['longitude']; ?></b></p>
                </div>
                <div class="mb-3">
                    <label for="sitename" class="form-label">Site name</label>
                    <input type="text" class="form-control" id="sitename" name="sitename" value="<?php echo $row['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required><?php echo $row['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <input type="file" name="upload_image">
                    <?php if (!empty($row['image'])): ?>
                    <p>*If you don't upload an image, registered image won't change. Registered image name: <?php echo $row['image']; ?></p>
                    <?php endif ?>
                    <?php if (!empty($_FILES['upload_image']['error'])): ?>
                    <p class="error" style="color:red"><?php $_FILES['upload_image']['error']?></p>
                    <?php endif ?>
                </div>
                <input type="hidden" name="siteId" id="siteId" value="<?php echo $row["id"] ?>">
                <input type="submit" value="Change" name="change" class="btn btn-success">
                <input type="button" value="Delete" name="delete" class="btn btn-success" onclick="onDeleteButtonClick();">
                <input type="reset" value="Reset" name="reset" class="btn btn-success">
                <input type="button" value="Back" name="back" class="btn btn-success" onclick="location.href='../pages/mysites.php'">
            </form>
        </div>
    
        <script>
            function onChangeButtonClick() {
                var answer = confirm('Are you sure you want to change this site?');
                return answer;
            }

            function onDeleteButtonClick() {
                // Get site ID from HTML using hidden type
                var siteId = document.getElementById("siteId").value;
                //alert(siteId);

                // Show the message to confirm deletion
                var answer = confirm('Are you sure you want to delete this site?');

                // If the user click "OK"
                if(answer === true){
                    // Call deleteSite.php with site ID
                    fetch('deleteSite.php', { // Destination
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(siteId.toString()) // Convert to json format and attach
                    });
                    //.then(response => response.json()) // Receive the returned response by json and pass it to the next then
                    //.then(res => {
                    //    console.log(res); // Returned data
                    //})

                    // Show the message and transition to mysites page
                    if(!alert('Deleted!')){
                        location.href = "../pages/mysites.php";
                    }   
                }
            }
        </script>

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