<?php

namespace Database\Seeders;

use App\Models\Types\Institution;
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
        $i = 1;
        foreach ($institutions as $institution_name) {
            if (!Institution::query()->where("name", $institution_name)->exists()) {
                Institution::factory(["name" => $institution_name, "id" => $i])->create();
            }
            $i++;
        }
    }
}
