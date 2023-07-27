<?php
session_start();

//Delete session variables
$_SESSION = array();
//Delete session
session_destroy();

//Redirect to home page
header('Location: ../index.php');
exit;
