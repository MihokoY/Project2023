<?php
// Start session processing
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
              crossorigin="anonymous">
        <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
        <link rel="stylesheet" href="css/external.css">
        <link rel="stylesheet" href="css/external_footer.css">
    </head>
    <body>
        <!-- Top menu -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand title" href="#">Archaeological map in Ireland</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Menu for logged in users -->
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/map.php">Explore map</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/mymap.php">My map</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/mysites.php">My sites</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="php/logout.php">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white">&#128100;<?php echo $_SESSION["user_name"]; ?></a>
                        </li>
                    </ul>
                </div>
                <!-- Menu for not logged in users -->
                <?php else: ?>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/map.php">Explore map</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/register.php">Join us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/login.php">Login</a>
                        </li>
                    </ul>
                </div>
                <?php endif ?>
            </div>
        </nav>
        
        <!-- Slideshow part -->
        <div id="carouselExampleCaptions" class="carousel slide mt-2" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/home1.jpg" class="d-block w-50 mx-auto" alt="home1">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Explore the Map</h3>
                        <h6><a href="pages/map.php">Let's explore our map! ⇒</a></h6>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/home2.jpg" class="d-block w-50 mx-auto" alt="home2">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Join a membership</h3>
                        <h6><a href="pages/register.php">Let's join a membership and create our map together! ⇒</a></h6>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/home3.jpg" class="d-block w-50 mx-auto" alt="home3">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Add new site</h3>
                        <h6><a href="pages/map.php">Let's add new site into our map! ⇒</a></h6>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Footer -->
        <footer class="footer bg-dark">
            <div class="container text-center mt-1">
                <p class="text-white title">©2023 Archaeology club, Inc. All Rights Reserved</p>
            </div>
        </footer>

        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
        <!--<script src="js/bootstrap.min.js"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
                crossorigin="anonymous"></script>
    </body>
</html>