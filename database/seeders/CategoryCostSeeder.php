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
        $categoryCosts = CategoryCost::getBaseArrayCategory();

        foreach ($categoryCosts as $category) {
            if (!CategoryCost::query()->where("id", $category["id"])->exists()) {
                CategoryCost::factory([
                    "name" => $category["name"],
                    "is_profit" => $category["is_profit"],
                    "is_set_child" => $category["is_set_child"],
                    "is_set_staff" => $category["is_set_staff"],
                    "is_active" => $category["is_active"]
                ])->create();
            } elseif (!CategoryCost::query()
                ->where("name", $category["name"])
                ->where("is_profit", $category["is_profit"])
                ->where("is_set_child", $category["is_set_child"])
                ->where("is_set_staff", $category["is_set_staff"])
                ->where("is_active", $category["is_active"])
                ->exists()) {
                CategoryCost::query()->where("id", $category["id"])->update([
                    "name" => $category["name"],
                    "is_profit" => $category["is_profit"],
                    "is_set_child" => $category["is_set_child"],
                    "is_set_staff" => $category["is_set_staff"],
                    "is_active" => $category["is_active"]
                ]);
            }
        }
    }
}
