<?php

require_once 'Database.php';

$db = (new Database())->connect();

// Create the migrations table if it does not exist
$db->exec("CREATE TABLE IF NOT EXISTS migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);");

// Fetch existing migrations
$existingMigrations = $db->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);

// Iterate through migration files
$migrationsPath = __DIR__ . '/migrations';
$files = scandir($migrationsPath);
$executed = 0;

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;

    if (!in_array($file, $existingMigrations)) {
        echo "Running migration: $file\n";
        require "$migrationsPath/$file";

        // Insert into the database
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
