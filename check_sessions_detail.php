<?php
require 'vendor/autoload.php';

$pdo = new PDO('mysql:host=127.0.0.1;dbname=risk_management', 'root', '');

echo "===== SESSIONS TABLE STRUCTURE =====\n";
$stmt = $pdo->query('DESCRIBE sessions');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo "{$col['Field']}: {$col['Type']} ({$col['Null']}) \n";
}

echo "\n===== RECENT SESSIONS =====\n";
$stmt = $pdo->query('SELECT id, user_id, ip_address, last_activity FROM sessions ORDER BY last_activity DESC LIMIT 5');
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($sessions);

echo "\n===== USERS TABLE (remember_token) =====\n";
$stmt = $pdo->query('DESCRIBE users');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    if (strpos($col['Field'], 'token') !== false) {
        echo "{$col['Field']}: {$col['Type']} ({$col['Null']}) \n";
    }
}
