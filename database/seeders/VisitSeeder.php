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
        $positions = ["Не выбрано", "Целый день", "Пол дня", "Больничный", "Отпуск", "Пропущено"];
        $i = 0;
        foreach ($positions as $position_name) {
            if (Visit::where("name", $position_name)->count() == 0)
                    Visit::factory(["name" => $position_name, "id" => $i])->create();
            $i++;
        }
    }
}
