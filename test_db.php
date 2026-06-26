<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'furninest1';

// Test 3307
try {
    $conn = new mysqli($host, $user, $pass, $db, 3307);
    if ($conn->connect_error) {
        echo "3307 gagal: " . $conn->connect_error . "\n";
    } else {
        echo "3307 success\n";
    }
} catch (Exception $e) {
    echo "3307 exception: " . $e->getMessage() . "\n";
}

// Test 3306
try {
    $conn2 = new mysqli($host, $user, $pass, $db, 3306);
    if ($conn2->connect_error) {
        echo "3306 gagal: " . $conn2->connect_error . "\n";
    } else {
        echo "3306 success\n";
    }
} catch (Exception $e) {
    echo "3306 exception: " . $e->getMessage() . "\n";
}
