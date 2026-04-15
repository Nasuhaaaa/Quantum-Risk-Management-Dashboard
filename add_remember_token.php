<?php
require 'vendor/autoload.php';

$pdo = new PDO('mysql:host=127.0.0.1;dbname=risk_management', 'root', '');

// Check if remember_token already exists
$stmt = $pdo->query("DESCRIBE users");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
$hasRememberToken = false;

foreach ($columns as $col) {
    if ($col['Field'] === 'remember_token') {
        $hasRememberToken = true;
        break;
    }
}

if ($hasRememberToken) {
    echo "remember_token column already exists\n";
} else {
    echo "Adding remember_token column...\n";
    $pdo->exec("ALTER TABLE users ADD COLUMN remember_token VARCHAR(100) NULL");
    echo "remember_token column added successfully\n";
}

// Verify the table now
echo "\nFinal users table structure:\n";
$stmt = $pdo->query('DESCRIBE users');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo "{$col['Field']}: {$col['Type']} ({$col['Null']}) \n";
}
