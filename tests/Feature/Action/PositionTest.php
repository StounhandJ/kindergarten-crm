<?php

namespace Tests\Feature\Action;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PositionTest extends TestCase
{
    /**
     * Base data institution
     *
     * @return void
     */
    public function test_base_position()
    {
        $response = $this->getJson('/action/position');

        $response
            ->assertStatus(200)
            ->assertExactJson(
                [
                    ["id" => 1, "name" => "Директор", "e_name" => "director"],
                    ["id" => 2, "name" => "Старший воспитатель", "e_name" => "senior_tutor"],
                    ["id" => 3, "name" => "Воспитатель", "e_name" => "tutor"],
                    ["id" => 4, "name" => "Повар", "e_name" => "cook"],
                ]
            );
    }
}
