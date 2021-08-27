<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::factory(["name" => "Первый"])->create();
        Branch::factory(["name" => "Второй"])->create();
    }
}
