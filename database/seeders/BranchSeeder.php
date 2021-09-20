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
        $branches = ["Первый", "Второй"];
        $i = 1;
        foreach ($branches as $branch_name)
        {
            if (!Branch::query()->where("name", $branch_name)->exists()) Branch::factory(["name"=>$branch_name, "id"=>$i])->create();
            $i++;
        }
    }
}
