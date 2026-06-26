<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'furninest1';

try {
    $dsn = "mysql:host=$host;port=3307;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    echo "3307 success\n";
} catch (PDOException $e) {
    echo "3307 error: " . $e->getMessage() . "\n";
}

try {
    $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    echo "3306 success\n";
} catch (PDOException $e) {
    echo "3306 error: " . $e->getMessage() . "\n";
}
