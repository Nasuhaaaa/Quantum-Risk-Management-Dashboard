<?php
require 'vendor/autoload.php';

$pdo = new PDO('mysql:host=127.0.0.1;dbname=risk_management', 'root', '');
$stmt = $pdo->query('SHOW TABLES LIKE "sessions"');
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($result)) {
    echo "SESSIONS TABLE DOES NOT EXIST\n";
} else {
    echo "SESSIONS TABLE EXISTS\n";
    print_r($result);
}

// Also check migrations to see if sessions migration ran
echo "\n\nRecent Migrations:\n";
$stmt = $pdo->query('SELECT * FROM migrations ORDER BY batch DESC LIMIT 5');
$migrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($migrations);
