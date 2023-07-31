<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Logged out</title>
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
                            <a class="nav-link" href="../pages/register.php">Join us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Completion message display part -->
        <div class="container mt-2">
            <div class="relative">
                <img src="../images/logout.jpg" alt="backimage">
                <div class="absolute4">
                    <h1 class="text-white">Logged out!</h1>
                    <h2 class="text-white"><a href="../index.php">Back to Home ⇒</a></h2>
                </div>
            </div>
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