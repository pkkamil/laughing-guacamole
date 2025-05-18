<?php

namespace App\Database;

require_once __DIR__ . '/../../vendor/autoload.php';

class DatabaseSeeder
{
    /**
     * List of seeders to run.
     * Add more seeder classes here if needed.
     */
    private array $seeders = [
        \App\Database\Seeders\ProductsSeeder::class,
        \App\Database\Seeders\UserSeeder::class,
    ];

    public function run(): void
    {
        foreach ($this->seeders as $seederClass) {
            echo "Running seeder: $seederClass\n";
            $seeder = new $seederClass();
            $seeder->run();
        }

        echo "All seeders have been run.\n";
    }
}

(new \App\Database\DatabaseSeeder())->run();
