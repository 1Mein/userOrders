<?php

$host = 'localhost:3306';
$dbName = 'userOrders';
$username = 'root';
$password = 'password';


try {
    $pdo = new PDO("mysql:host=$host", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $pdo->exec("USE $dbName");

} catch (PDOException $e) {
    die('connection error: ' . $e->getMessage());
}