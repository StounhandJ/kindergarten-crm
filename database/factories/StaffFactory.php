<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Staff;
use App\Models\Types\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fio' => sprintf("%s %s", $this->withFaker()->firstName(), $this->withFaker()->lastName()),
            'group_id' => Group::factory()->create()->getId(),
            "user_id" => User::factory()->create()->getId(),
            "position_id" => Position::all()->random()->getId(),
            "address" => $this->withFaker()->address(),
            "phone" => $this->withFaker()->phoneNumber(),
            "date_birth" => $this->withFaker()->dateTime(),
            "date_employment" => $this->withFaker()->dateTime(),
            "reason_dismissal" => "Возможно есть",
        ];
    }
}
