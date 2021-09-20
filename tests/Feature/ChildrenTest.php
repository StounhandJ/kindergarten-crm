<?php

namespace Tests\Feature;

use App\Models\Child;
use Illuminate\Testing\Fluent\AssertableJson;
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
        $response = $this->json('GET', '/action/children', ["limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    public function test_children_limit_page()
    {
        $response = $this->json('GET', '/action/children', ["limit" => 3, "page" => 2]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    public function test_children_show()
    {
        $child = Child::all()->random();
        $response = $this->json('GET', '/action/children/' . $child->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $child->getId());
    }

    public function test_children_attribute_hidden()
    {
        $child = Child::all()->random();
        $response = $this->json('GET', '/action/children/' . $child->getId());

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                        $json->missingAll(['records.deleted_at', 'records.created_at', 'records.updated_at'])
            );
    }
}
