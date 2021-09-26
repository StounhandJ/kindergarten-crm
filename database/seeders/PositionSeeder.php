<?php

namespace Database\Seeders;

use App\Models\Types\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                "name" => "Директор",
                "e_name" => "director"
            ],
            [
                "name" => "Старший воспитатель",
                "e_name" => "senior_tutor"
            ],
            [
                "name" => "Воспитатель",
                "e_name" => "tutor"
            ],
            [
                "name" => "Повар",
                "e_name" => "cook"
            ]
        ];
        $i = 1;
        foreach ($positions as $position) {
            if (!Position::query()->where("id", $i)->exists()) {
                Position::factory([
                    "id"=>$i,
                    "name" => $position["name"],
                    "e_name" => $position["e_name"]
                ])->create();
            }
            elseif (!Position::query()->where("name", $position["name"])->where("e_name", $position["e_name"])->exists())
            {
                Position::query()->where("id", $i)->update([
                    "name" => $position["name"],
                    "e_name" => $position["e_name"]
                ]);
            }
            $i++;
        }
    }
}
