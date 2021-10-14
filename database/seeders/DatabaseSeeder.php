<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BranchSeeder::class,
            InstitutionSeeder::class,
            PositionSeeder::class,
            VisitSeeder::class,
            StaffSeeder::class,
            CategoryCostSeeder::class
        ]);
    }
}
