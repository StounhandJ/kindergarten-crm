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
        $positions = ["Директор", "Старший воспитатель", "Воспитатель", "Повар"];
        foreach ($positions as $position_name)
            if (Position::where("name", $position_name)->count()==0) Position::factory(["name"=>$position_name])->create();
    }
}
