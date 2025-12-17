<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * This currently seeds the routes and paths
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Load and execute the .sql file
        $path = database_path('sql/RoutesAndAddresses.sql');

        if (file_exists($path)) {
            $sql = file_get_contents($path); // Load the SQL file content
            DB::unprepared($sql); // Execute the SQL
        } else {
            $this->command->error("SQL file not found at path: $path");
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
