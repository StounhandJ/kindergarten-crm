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
                "name"=>"Директор",
                "e_name"=>"director"
            ],
            [
                "name"=>"Старший воспитатель",
                "e_name"=>"senior_tutor"
            ],
            [
                "name"=>"Воспитатель",
                "e_name"=>"tutor"
            ],
            [
                "name"=>"Повар",
                "e_name"=>"cook"
            ]
        ];
        foreach ($positions as $position)
            if (Position::query()->where("name", $position["name"])->where("e_name", $position["e_name"])->count()==0)
                Position::factory([
                    "name"=>$position["name"],
                    "e_name"=>$position["e_name"]
                ])->create();
    }
}
