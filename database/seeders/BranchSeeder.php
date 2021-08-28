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
        foreach ($branches as $branch_name)
            if (Branch::where("name", $branch_name)->count()==0) Branch::factory(["name"=>$branch_name])->create();
    }
}
