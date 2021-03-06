<?php

namespace Database\Factories\Cost;

use App\Models\Cost\CategoryCost;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryCostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryCost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->withFaker()->userName(),
            "is_profit" => $this->withFaker()->boolean(),
            "is_set_child" => $this->withFaker()->boolean(),
            "is_set_staff" => $this->withFaker()->boolean(),
            "is_active" => true
        ];
    }
}
