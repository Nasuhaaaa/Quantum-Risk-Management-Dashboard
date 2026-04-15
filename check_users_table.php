<?php
// Simple PHP script to check database state
require 'vendor/autoload.php';

$pdo = new PDO(
    'mysql:host=127.0.0.1;database=risk_management',
    'root',
    ''
);

echo "=== USERS TABLE STRUCTURE ===\n";
$columns = $pdo->query("DESCRIBE users")->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo $col['Field'] . " (" . $col['Type'] . ")\n";
}

echo "\n=== MIGRATIONS TABLE (Last 10) ===\n";
$migrations = $pdo->query("SELECT * FROM migrations ORDER BY id DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
foreach ($migrations as $mig) {
    echo $mig['migration'] . " - Batch: " . $mig['batch'] . "\n";
}
