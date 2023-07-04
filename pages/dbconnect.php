<?php
try{
    $db = new PDO('mysql:host=localhost;dbname=project2023;charset=utf8mb4', 'root', 'pass2023+');
}catch (PDOException $e) {
    echo "Database connection error　：".$e->getMessage();
}
?>
