<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institutions = ["Детский сад", "Продленка", "Лагерь"];

        foreach ($institutions as $institution_name)
            if (Institution::where("name", $institution_name)->count()==0) Institution::factory(["name"=>$institution_name])->create();
    }
}
