<?php
//Conneco to the database
require('../php/dbconnect.php');

// When the Register button is clicked
if (!empty($_POST)) {

    //Check if there is a duplicate email in the member table
    $member = $db->prepare('SELECT COUNT(*) as cnt FROM member WHERE email=?');
    $member->execute(array(
        $_POST['email']
    ));
    $record = $member->fetch();
    // If there is a duplicate email, put "duplicate" in the variable for errors
    if ($record['cnt'] > 0) {
        $error['email'] = "duplicate";
    }

    //Email validation
    if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // If it is invalid, put "invalid" in the variable for errors
        $error['email'] = "invalid";
    }

    //Password validation
    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
        $h_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    } else {
        // If it is invalid, put "invalid" in the variable for errors
        $error['password'] = "invalid";
    }

    // If there is no error, update the database
    if (!isset($error)) {
        // Insert the data into the member table
        $stmt = $db->prepare("INSERT INTO member(name, email, pass, flg) VALUE(?, ?, ?, ?)");
        $stmt->execute([$_POST['username'], $_POST['email'], $h_password, 1]);

        // Move to register_complete page
        header('Location: register_complete.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Join a membership</title>
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

        <!-- Register form -->
        <div class="container mt-3">
            <h2 class="login_h2">Join a membership</h2>
            <form id="registerForm" name="registerForm" action=""  method="POST">           
                <div class="mb-3">
                    <label for="username" class="form-label">User name</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                    <!-- If the email is already registered or invalid, show the error message -->
                    <?php if (!empty($error["email"]) && $error['email'] === 'duplicate'): ?>
                        <p class="error" style="color:red">*This email is already registered.</p>
                    <?php elseif (!empty($error["email"]) && $error['email'] === 'invalid'): ?>
                        <p class="error" style="color:red">*The value you entered is invalid.</p>
                    <?php endif ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordRule" required>
                    <!-- If the password is invalid, show the error message -->
                    <?php if (!empty($error["password"]) && $error['password'] === 'invalid'): ?>
                        <p class="error" style="color:red">*The value you entered is invalid.</p>
                    <?php endif ?>
                    <div id="passwordRule" class="form-text">
                        Your password must be at least 8 characters, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                    </div>
                </div>
                <button type="submit" id="register" name="register" class="btn btn-success">Register</button>
                <input type="reset" value="Reset" name="reset" class="btn btn-success">
                <input type="button" value="Back" name="back" class="btn btn-success" onclick="location.href='../index.php'">
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