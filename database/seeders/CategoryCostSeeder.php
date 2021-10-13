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
                "is_profit" => false
            ],
            [
                "name" => "Оплата за детей",
                "is_profit" => true
            ]
        ];
        if (CategoryCost::query()->count() == 0) {
            foreach ($categoryCosts as $categoryCost) {
                CategoryCost::factory($categoryCost)->create();
        }
        }
    }
}
