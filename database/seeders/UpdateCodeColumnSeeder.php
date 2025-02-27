<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateCodeColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("ALTER TABLE sub_services MODIFY COLUMN code VARCHAR(255) UNIQUE");
        $this->command->info("Column 'code' has been changed to VARCHAR(255).");
    }
}
