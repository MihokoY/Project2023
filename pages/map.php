<?php
session_start();
// If the user is logged in, redirect to this page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/external.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand title" href="#">Archaeological map in Ireland</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
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
            <?php else: ?>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/map.php">Explore map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/register.php">Join member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/login.php">Login</a>
                    </li>
                </ul>
            </div>
            <?php endif ?>
        </div>
    </nav>
    

</body>
</html>