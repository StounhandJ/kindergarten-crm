<?php

namespace Database\Seeders;

use App\Models\Visit;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = ["Целый день", "Пол дня", "Больничный", "Отпуск", "Пропущено"];
        foreach ($positions as $position_name)
            if (Visit::where("name", $position_name)->count()==0) Visit::factory(["name"=>$position_name])->create();
    }
}
