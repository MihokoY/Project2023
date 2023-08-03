<?php
// Start session processing
session_start();

//If the user is not logged in, redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header('Location: ../pages/login.php');
    exit;
}

//If the user transitions after changing the site, show a completion message
//if(isset($_SESSION["fromChangeSite"]) && $_SESSION["fromChangeSite"] === true){
//    echo "<script>alert('Changed!');</script>";
//    $_SESSION["fromChangeSite"] = false;
//}

// Connect to the database
require('dbconnect.php');
// Get site information of the user
$stmt = $db->prepare("SELECT * FROM sites WHERE user_id = ? and flg = 1");
$stmt->bindValue(1, $_SESSION["user_id"]);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My sites</title>
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
        
        <!-- Title -->
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <h2>My sites</h2>
                </div>
            </div>
        </div>
        
        <!-- If the user does not have any registered site, show below -->
        <?php if($stmt->rowCount() === 0): ?>
        <div class="container py-3 mb-2 border border-secondary border-2">
            <div class="row">
                <div class="col-6">
                    <h3>No site registered yet.</h3>
                    <h4><a href="../pages/map.php" class="link-dark">Let's add new site ⇒</a></h4>
                </div>
                <div class="col-6">
                    <img class="w-100" src="../images/nosite.jpg">
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Display sites -->
        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
        <div class="container py-3 mb-2 border border-secondary border-2">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="fst-italic"><?php echo $row["name"]; ?></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="fw-bold">Latitude:&nbsp;<?php echo $row["latitude"]; ?> , Longitude:&nbsp;<?php echo $row["longitude"]; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p><?php echo $row["description"]; ?></p>
                        </div>
                    </div>                  
                </div>
                <?php if ($row["image"] !== null){ ?>
                <div class="col-6">
                    <img class="w-100" src="../images/<?php echo $row["image"]; ?>">
                </div>
                <?php }else{ ?>
                <div class="col-6">
                    <p><b>No image</b></p>
                </div>
                <?php } ?>
            </div>
            <div class="row">              
                <div class="col-12 text-end mt-3">
                    <form name="mysitesForm" action="editsite.php" method="post">
                        <input type="hidden" name="siteId" id="siteId" value="<?php echo $row["id"] ?>">
                        <input type="submit" name="edit" value="Edit" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Footer -->
        <footer class="footer bg-dark">
            <div class="container text-center mt-2">
                <p class="text-white title">©2023 Archaeology club, Inc. All Rights Reserved</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
                crossorigin="anonymous"></script>
    </body>
</html>