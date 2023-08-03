<?php
// Start session processing
session_start();

//If the user is not administrator, redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_id"] !== 1){
    header('Location: ../pages/login.php');
    exit;
}

// Connect to the database
require('dbconnect.php');
// Get all site information
$stmt = $db->prepare("SELECT * FROM member");
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage members</title>
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
                            <a class="nav-link" href="../pages/managesites.php">Manage sites</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/managemembers.php">Manage members</a>
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
        <div class="row m-3">
            <div class="col-12">
                <h2>Manage members</h2>
            </div>
        </div>
        
        <!-- Display mambers -->
        <div class="row mx-3">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Created date</th>
                            <th scope="col">Change validity</th>
                        </tr>
                    </thead>
                    <tbody>       
                    <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
                        <?php if ($row["flg"] === 1){ ?>
                        <tr>
                        <?php }else{ ?>
                        <tr class="bg-secondary">
                        <?php } ?>
                            <th scope="row"><?php echo $row["id"]; ?></th>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["created_date"]; ?></td>
                            <td>
                                <form name="managesitesForm" action="changeMemberFlg.php" onsubmit="return onValidityButtonClick()" method="POST">
                                <input type="hidden" name="postData[0]" id="siteId" value="<?php echo $row["id"] ?>">
                                <input type="hidden" name="postData[1]" id="flag" value="<?php echo $row["flg"] ?>">
                                <?php if ($row["id"] === 1){ ?>
                                <input type="submit" name="validity" value="Change" class="btn btn-success" disabled>
                                <?php }else{ ?>
                                <input type="submit" name="validity" value="Change" class="btn btn-success">
                                <?php } ?>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer bg-dark">
            <div class="container text-center mt-2">
                <p class="text-white title">©2023 Archaeology club, Inc. All Rights Reserved</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
                crossorigin="anonymous"></script>
        <script src="../js/editSite.js"></script>
    </body>
</html>