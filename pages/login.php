<?php
require_once "dbconnect.php";

//Start session
session_start();

// If the user is logged in, redirect to map page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: map.php");
    exit;
}

if (!empty($_POST)) {
    // Blank check
    if ($_POST['email'] === "") {
        $error['email']  = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password']  = "blank";
    }
    
    if (!isset($error)) {
        //Get the relevant user information from email
        $stmt = $db->prepare('select * from member where email = ?');
        //$stmt->bindValue('email',$datas['email'],PDO::PARAM_INT);
        $stmt->execute([$_POST['email']]);

            //If there is user information, it is stored in a variable
            if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                //Check if the password is correct
                if (password_verify($_POST['password'],$row['pass'])) {
                    //Set a new session ID
                    session_regenerate_id(true);
                    //Store login information in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $row['id'];
                    //$_SESSION["name"] =  $row['name'];
                    //Redirect to map page
                    header("location:map.php");
                    exit();
                } else {
                    $error['password'] = "invalid";
                }
            }else {
                $error['email'] = "invalid";
            }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <div class="container mt-3">
        <h2 class="login_h2">Login</h2>
        <?php if (!empty($error["email"]) && $error['email'] === 'blank'): ?>
            <p class="error" style="color:red">*Please enter your email and password.</p>
        <?php elseif (!empty($error["password"]) && $error['password'] === 'blank'): ?>
            <p class="error" style="color:red">Invalid username or password.</p>
        <?php elseif (!empty($error["email"]) && $error['email'] === 'invalid'): ?>
            <p class="error" style="color:red">*Invalid username or password.</p>
        <?php elseif (!empty($error["password"]) && $error['password'] === 'invalid'): ?>
            <p class="error" style="color:red">*Invalid username or password.</p>
        <?php endif ?>
        <form id="loginForm" name="loginForm" action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" name="password">
            </div>

            <!--
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember</label>
            </div>
            -->
            <button type="submit" class="btn btn-success">Login</button>
            <p>Not our member? <a href="register.php">Join member now</a></p>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
            crossorigin="anonymous"></script>
</body>
</html>