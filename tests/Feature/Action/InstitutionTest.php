<?php

namespace Tests\Feature\Action;

use Tests\TestCase;

class InstitutionTest extends TestCase
{
    /**
     * Base data institution
     *
     * @return void
     */
    public function test_base_institution()
    {
        $response = $this->getJson('/action/institution');

        $response
            ->assertStatus(200)
            ->assertExactJson(
                [
                    ["id" => 1, "name" => "Детский сад"],
                    ["id" => 2, "name" => "Продленка"],
                    ["id" => 3, "name" => "Лагерь"],
                ]
            );
    }
}
