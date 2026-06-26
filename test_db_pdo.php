<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3307;dbname=furninest1', 'root', '');
    $stmt = $pdo->query('SELECT COUNT(*) FROM products');
    var_dump($stmt);
} catch (Exception $e) {
    echo "3307 failed: " . $e->getMessage() . "\n";
}
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=furninest1', 'root', '');
    $stmt = $pdo->query('SELECT COUNT(*) FROM products');
    var_dump($stmt);
} catch (Exception $e) {
    echo "3306 failed: " . $e->getMessage() . "\n";
}
