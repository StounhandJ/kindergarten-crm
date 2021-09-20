<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\Group;
use App\Models\Types\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChildFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fio' => sprintf("%s %s", $this->withFaker()->firstName(), $this->withFaker()->lastName()),
            'group_id' => Group::factory()->create(),
            'institution_id' => Institution::all()->random(),
            "address" => $this->withFaker()->address(),
            "fio_mother" => sprintf("%s %s", $this->withFaker()->firstNameFemale(), $this->withFaker()->lastName()),
            "phone_mother" => $this->withFaker()->phoneNumber(),
            "fio_father" => sprintf("%s %s", $this->withFaker()->firstNameMale(), $this->withFaker()->lastName()),
            "phone_father" => $this->withFaker()->phoneNumber(),
            "rate" => $this->withFaker()->numberBetween(100, 20000),
            "date_birth" => $this->withFaker()->dateTime(),
            "date_enrollment" => $this->withFaker()->dateTime(),
        ];
    }
}
