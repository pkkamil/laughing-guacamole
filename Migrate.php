<?php

require_once 'Database.php';

$db = (new Database())->connect();

$shouldFresh = in_array('--fresh', $argv);

// If --fresh is provided, drop all tables
if ($shouldFresh) {
    echo "Dropping all tables...\n";

    // Temporarily disable foreign key checks
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Fetch all tables
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        $db->exec("DROP TABLE IF EXISTS `$table`");
        echo "Dropped table: $table\n";
    }

    // Re-enable foreign key checks
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "All tables dropped.\n";
}

// Create the migrations table if it doesn't exist
$db->exec("CREATE TABLE IF NOT EXISTS migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);");

// Fetch already executed migrations
$existingMigrations = $db->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);

// Path to migrations
$migrationsPath = __DIR__ . '/migrations';
$files = scandir($migrationsPath);
$executed = 0;

// Sort files
usort($files, fn($a, $b) => strcmp($a, $b));

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;

    if ($shouldFresh || !in_array($file, $existingMigrations)) {
        echo "Running migration: $file\n";
        require "$migrationsPath/$file";

        $stmt = $db->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
        $stmt->execute(['migration' => $file]);
        $executed++;
    }
}

if ($executed === 0) {
    echo "No new migrations.\n";
} else {
    echo "Executed $executed migrations.\n";
}
