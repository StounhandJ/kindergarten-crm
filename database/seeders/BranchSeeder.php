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
        if (Branch::all()->count()==0)
            foreach ($branches as $branch_name)
                Branch::factory(["name"=>$branch_name])->create();
    }
}
