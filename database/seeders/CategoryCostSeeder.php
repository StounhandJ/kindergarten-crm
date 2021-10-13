<?php

namespace Database\Seeders;

use App\Models\Cost\CategoryCost;
use Illuminate\Database\Seeder;

class CategoryCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryCosts = [
            [
                "name" => "ЗП",
                "is_profit" => false,
                "is_set_child" => false,
                "is_set_staff" => true
            ],
            [
                "name" => "Оплата за детей",
                "is_profit" => true,
                "is_set_child" => true,
                "is_set_staff" => false
            ]
        ];
        if (CategoryCost::query()->count() == 0) {
            foreach ($categoryCosts as $categoryCost) {
                CategoryCost::factory($categoryCost)->create();
        }
        }
    }
}
