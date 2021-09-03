<?php

namespace Database\Factories;

use App\Models\JournalChild;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalChildFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JournalChild::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "create_date"=>now()
        ];
    }
}
