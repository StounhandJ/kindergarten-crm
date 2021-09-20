<?php

namespace Tests\Feature;

use App\Models\Child;
use Tests\TestCase;

class ChildrenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Child::factory()->count(10)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_children_limit()
    {
        $response = $this->json('GET','/action/children', ["limit"=>3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    public function test_children_limit_page()
    {
        $response = $this->json('GET', '/action/children', ["limit"=>3, "page"=>2]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }
}
