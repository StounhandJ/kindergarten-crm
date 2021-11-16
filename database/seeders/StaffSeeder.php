<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Group;
use App\Models\Staff;
use App\Models\Types\Position;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Staff::query()->count() == 0) {
            Staff::make(
                "ФИО",
                "+7(000)000000",
                "-",
                Carbon::now(),
                Carbon::now(),
                null,
                null,
                25000,
                new Group(),
                new Branch(),
                Position::getById(Position::DIRECTOR),
                "admin",
                "admin"
            )->save();
        }
    }
}
