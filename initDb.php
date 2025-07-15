<?php

require_once 'src/connection.php';

try {
    /** @var $pdo */
    /** @var $dbName */
    $pdo->exec("DROP DATABASE IF EXISTS $dbName");
    $pdo->exec("CREATE DATABASE $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "db created\n";

    $pdo->exec("USE $dbName");

    $pdo->exec("
        CREATE TABLE users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255),
            email VARCHAR(255)
        );
    ");

    $pdo->exec("
        CREATE TABLE orders (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT,
            amount DECIMAL(10,2),
            created_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
    ");

    echo "tables created\n";

    $pdo->exec("
        INSERT INTO users (name, email) VALUES
        ('Иван', 'ivan@example.com'),
        ('Мария', 'maria@example.com'),
        ('Петр', 'petr@example.com')
    ");

    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, amount, created_at) VALUES (:user_id, :amount, :created_at)
    ");

    $now = fn($rel) => date('Y-m-d H:i:s', strtotime($rel));

    $sql = "
        INSERT INTO orders (user_id, amount, created_at) VALUES
            (1, 500.25, '{$now('-5 days')}'),
            (1, 300.00, '{$now('-3 days')}'),
            (1, 700.25, '{$now('-1 days')}'),
            (2, 1200.00, '{$now('-10 days')}'),
            (3, 150.00, '{$now('-40 days')}')
    ";

    $pdo->exec($sql);


    echo "tables seeded\n";
} catch (PDOException $e) {
    die("error while seed: " . $e->getMessage());
}
