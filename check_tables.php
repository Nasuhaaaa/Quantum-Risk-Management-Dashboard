<?php
require 'vendor/autoload.php';

$pdo = new PDO('mysql:host=127.0.0.1;dbname=risk_management', 'root', '');

// Check users table structure
echo "===== USERS TABLE COLUMNS =====\n";
$stmt = $pdo->query('DESCRIBE users');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo "{$col['Field']}: {$col['Type']} ({$col['Null']}) \n";
}

// Check if User records have the expected data
echo "\n===== SAMPLE USER RECORD =====\n";
$stmt = $pdo->query('SELECT * FROM users WHERE username = "entiti.user" LIMIT 1');
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
    print_r($user);
} else {
    echo "User not found!\n";
}

// Check JenisPengguna relationship
echo "\n===== JENIS_PENGGUNA TABLE =====\n";
$stmt = $pdo->query('DESCRIBE jenis_pengguna');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo "{$col['Field']}: {$col['Type']} \n";
}
