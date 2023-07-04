<?php
//Conneco to database
require('dbconnect.php');

if (!empty($_POST)) {
    // Blank check
    if ($_POST['username'] === "") {
        $error['username'] = "blank";
    }
    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }

    if (!isset($error)) {
        //Check if it is a duplicate email in the database.
        $member = $db->prepare('SELECT COUNT(*) as cnt FROM member WHERE email=?');
        $member->execute(array(
            $_POST['email']
        ));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        }

        //Email validation
        if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'invalid';
            //return false;
        }

        //Password validation
        if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
            $h_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        } else {
            $error['$password'] = 'invalid';
            //return false;
        }
    }

    if (!isset($error)) {
        // Set data into database
        $stmt = $db->prepare("insert into member(name, email, pass) value(?, ?, ?)");
        $stmt->execute([$_POST['username'], $_POST['email'], $h_password]);

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
    <title>Join member</title>
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
    
    <div class="container">
        <h2 class="login_h2">Join member</h2>
        <form id="registerForm" name="registerForm" action=""  method="POST">           
            <div class="mb-3">
                <label for="username" class="form-label">User name</label>
                <input type="text" class="form-control" id="username" name="username">
                <?php if (!empty($error["username"]) && $error['username'] === 'blank'): ?>
                    <p class="error" style="color:red">*Please enter your username.</p>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="text" class="form-control" id="email" name="email">
                <?php if (!empty($error["email"]) && $error['email'] === 'blank'): ?>
                    <p class="error" style="color:red">*Please enter your email.</p>
                <?php elseif (!empty($error["email"]) && $error['email'] === 'duplicate'): ?>
                    <p class="error" style="color:red">*This email is already registered.</p>
                <?php elseif (!empty($error["email"]) && $error['email'] === 'invalid'): ?>
                    <p class="error" style="color:red">*The value you entered is invalid.</p>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" name="password" aria-describedby="passwordRule">
                <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
                    <p class="error" style="color:red">*Please enter your password.</p>
                <?php elseif (!empty($error["password"]) && $error['password'] === 'invalid'): ?>
                    <p class="error" style="color:red">*The value you entered is invalid.</p>
                <?php endif ?>
                <div id="passwordRule" class="form-text">
                    Your password must be at least 8 characters, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                </div>
            </div>
            <button type="submit" id="register" name="register" class="btn btn-primary">Register</button>
            <input type="reset" value="Reset" name="reset" class="btn btn-primary">
            <input type="button" value="Back" name="back" class="btn btn-primary" onclick="location.href='../index.php'">
        </form>
    </div>
</body>
</html>