<?php

// Konfigurasi koneksi ke port 3307 sesuai pengaturan XAMPP Anda
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$port = 3307;

echo "--- Memulai Proses Perbaikan Database ---\n";

// 1. Perbaiki Tabel phpMyAdmin
$connPma = @new mysqli($host, $user, $pass, 'phpmyadmin', $port);
if ($connPma->connect_error) {
    echo "Peringatan: Gagal koneksi ke database phpmyadmin: " . $connPma->connect_error . "\n";
} else {
    echo "Memperbaiki tabel pma__userconfig...\n";
    $result = $connPma->query("REPAIR TABLE pma__userconfig");
    if ($result) {
        echo "SUKSES: Tabel pma__userconfig berhasil diperbaiki.\n";
    } else {
        echo "GAGAL: " . $connPma->error . "\n";
    }
    $connPma->close();
}

// 2. Perbaiki Tabel Aplikasi (furninest)
$connApp = @new mysqli($host, $user, $pass, 'furninest', $port);
if ($connApp->connect_error) {
    echo "Peringatan: Gagal koneksi ke database furninest: " . $connApp->connect_error . "\n";
} else {
    echo "Mengecek dan memperbaiki semua tabel di furninest...\n";
    $tables = $connApp->query("SHOW TABLES");
    while ($row = $tables->fetch_array()) {
        $table = $row[0];
        $connApp->query("REPAIR TABLE `$table`") ;
        echo "- Tabel $table: OK\n";
    }
    $connApp->close();
}

echo "--- Proses Selesai ---\n";
