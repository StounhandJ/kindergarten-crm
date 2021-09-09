<?php

namespace Database\Factories\Cost;

use App\Models\Cost\Cost;
use Illuminate\Database\Eloquent\Factories\Factory;

class CostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function profit()
    {
        return $this->state([
            "is_profit" => true
        ]);
    }

    public function losses()
    {
        return $this->state([
            "is_profit" => false
        ]);
    }
}
