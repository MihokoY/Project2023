<?php
define('DSN','mysql:host=localhost;dbname=project2023');
define('DB_USER','root');
define('DB_PASSWORD','pass2023+');

try{
    $db = new PDO(DSN, DB_USER, DB_PASSWORD);
}catch (PDOException $e) {
    echo "Database connection error　：".$e->getMessage();
    exit;
}
?>
