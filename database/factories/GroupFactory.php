<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"=>$this->withFaker()->name(),
            "branch_id"=> Branch::all()->random(),
            "children_age"=>$this->withFaker()->numberBetween(2,6),
        ];
    }
}
