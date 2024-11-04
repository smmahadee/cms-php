<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=cms;charset=utf8mb4', 'cms', 'iD7pexkY8e[8jAY@', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch (PDOException $e) {
    // var_dump($e->getMessage());
    echo 'A problem occured with the database connection...';
    die();
}

