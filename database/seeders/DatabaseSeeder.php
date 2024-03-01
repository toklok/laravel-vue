<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\SavedCalculations;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Delete all rows from the table
        SavedCalculations::query()->delete();

        // Reset the auto-increment value to 0
        DB::statement("UPDATE sqlite_sequence SET seq = 0 WHERE name = 'saved_calculations'");
        
        // Create 10 new entries in the DB
        SavedCalculations::factory(10)->create();
    }
}
