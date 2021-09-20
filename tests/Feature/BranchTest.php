<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BranchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_base_branch()
    {
        $response = $this->getJson('/action/branch');

        $response
            ->assertStatus(200)
            ->assertExactJson(
                [
                    ["id"=>1, "name"=>"Первый"],
                    ["id"=>2, "name"=>"Второй"]
                ]
            );
    }
}
