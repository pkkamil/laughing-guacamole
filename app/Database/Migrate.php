<?php


namespace App\Database;

require_once __DIR__ . '/../../vendor/autoload.php';

// External dependencies
use PDO;

use App\DB;

class Migrate
{
    private PDO $db;
    private string $migrationsPath;

    public function __construct(private array $argv)
    {
        $this->db = (new DB())->connect();
        $this->migrationsPath = __DIR__ . '/Migrations';
    }

    public function run(): void
    {
        $shouldFresh = in_array('--fresh', $this->argv);

        if ($shouldFresh) {
            $this->dropAllTables();
        }

        $this->createMigrationsTable();

        $existingMigrations = $this->getExistingMigrations();

        $files = scandir($this->migrationsPath);
        usort($files, fn($a, $b) => strcmp($a, $b));

        $executed = 0;

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;

            if ($shouldFresh || !in_array($file, $existingMigrations)) {
                echo "Running migration: $file\n";
                $db = $this->db; 
                require "{$this->migrationsPath}/$file";

                $stmt = $this->db->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
                $stmt->execute(['migration' => $file]);
                $executed++;
            }
        }

        if ($executed === 0) {
            echo "No new migrations.\n";
        } else {
            echo "Executed $executed migrations.\n";
        }
    }

    private function dropAllTables(): void
    {
        echo "Dropping all tables...\n";
        $this->db->exec("SET FOREIGN_KEY_CHECKS = 0");
        $tables = $this->db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $this->db->exec("DROP TABLE IF EXISTS `$table`");
            echo "Dropped table: $table\n";
        }

        $this->db->exec("SET FOREIGN_KEY_CHECKS = 1");
        echo "All tables dropped.\n";
    }

    private function createMigrationsTable(): void
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
            id SERIAL PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );");
    }

    private function getExistingMigrations(): array
    {
        return $this->db->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);
    }
}

(new \App\Database\Migrate($argv))->run();
