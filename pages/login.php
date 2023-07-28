<?php
require_once "dbconnect.php";

// Start session processing
session_start();

// If the user is logged in, redirect to the map page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header('Location: map.php');
    exit;
}

// When the Login button is clicked
if (!empty($_POST)) {
    // Get the relevant user information from email
    $stmt = $db->prepare('select * from member where email = ?');
    $stmt->execute([$_POST['email']]);

    // Check if there is user information
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // Check if the password is correct
        if (password_verify($_POST['password'],$row['pass'])) {
            // Set a new session ID
            session_regenerate_id(true);
            // Store login information in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["user_id"] = $row['id'];
            // Transition to Map page
            header('Location:map.php');
            exit();
            
        // If the password is incorrect, put "invalid" in the variable for errors
        } else {
            $error['password'] = "invalid";
        }
    // If there is no user information, put "invalid" in the variable for errors
    }else {
        $error['email'] = "invalid";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
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
                            <a class="nav-link" href="../pages/register.php">Join member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Login form part-->
        <div class="container mt-3">
            <h2>Login</h2>
            <!-- If the email or password is incorrect, show the error message -->
            <?php if (!empty($error["email"]) && $error['email'] === 'invalid'): ?>
                <p class="error" style="color:red">*Invalid username or password.</p>
            <?php elseif (!empty($error["password"]) && $error['password'] === 'invalid'): ?>
                <p class="error" style="color:red">*Invalid username or password.</p>    
            <?php endif ?>
            <form id="loginForm" name="loginForm" action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-success">Login</button>
                <p>Not our member? <a href="register.php">Join member now</a></p>
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