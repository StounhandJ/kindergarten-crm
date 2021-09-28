<?php

namespace Tests\Feature\Action;

use App\Models\Branch;
use App\Models\Group;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GroupTest extends TestCase
{
    public function test_groups_limit()
    {
        Group::factory()->count(4)->create();

        $response = $this->json('GET', '/action/group', ["limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    /**
     * Checking pages
     *
     * @return void
     */
    public function test_groups_limit_page()
    {
        Group::factory()->count(4)->create();

        $response_one = $this->json('GET', '/action/group', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/group', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_groups_show()
    {
        $group = Group::factory()->create();

        $response = $this->json('GET', '/action/group/' . $group->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $group->getId());
    }

    public function test_groups_show_remote_group()
    {
        $this->assertDatabaseMissing("groups", [
            "id" => 789
        ]);

        $response = $this->json('GET', '/action/group/789');

        $response
            ->assertStatus(404);
    }

    public function test_groups_show_incorrect_group()
    {
        $group = Group::factory()->create();

        $response = $this->json('GET', '/action/group/' . -1);

        $response
            ->assertStatus(404);
    }

    public function test_groups_attribute_hidden()
    {
        $group = Group::factory()->create();

        $response = $this->json('GET', '/action/group/' . $group->getId());

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has("records")->
            missingAll(['delete_at', 'created_at', 'updated_at'])
                ->etc()
            );
    }

    public function test_groups_delete()
    {
        $group = Group::factory()->create();

        $response = $this->json('DELETE', '/action/group/' . $group->getId());

        $response->assertStatus(200);
    }

    public function test_groups_delete_remote_group()
    {
        $this->assertDatabaseMissing("groups", [
            "id" => 789
        ]);

        $response = $this->json('DELETE', '/action/group/789');

        $response->assertStatus(404);
    }

    public function test_groups_store()
    {
        Event::fake();
        $data = [
            "name" => "string",
            "children_age" => 10,
            "branch_id" => Branch::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/group', $data);

        $response
            ->assertStatus(200);
    }

    public function test_groups_store_null_required()
    {
        Event::fake();
        $data = [
            "name" => "string",
        ];
        $response = $this->json('POST', '/action/group', $data);

        $response
            ->assertStatus(422);
    }

    public function test_groups_store_incorrect_branch_id()
    {
        Event::fake();
        $data = [
            "name" => "string",
            "children_age" => 10,
            "branch_id" => -1,
        ];

        $response = $this->json('POST', '/action/group', $data);

        $response
            ->assertStatus(422);
    }


    public function test_groups_update()
    {
        Event::fake();

        $group = Group::factory()->create();

        $data = [
            "name" => "string",
            "children_age" => 10,
            "branch_id" => Branch::all()->random()->getId(),
        ];
        $response = $this->json('PUT', '/action/group/' . $group->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_groups_update_remote_group()
    {
        Event::fake();

        $group = Group::factory()->create();
        $group->delete();

        $data = [
            "name" => "string",
            "children_age" => 10,
            "branch_id" => Branch::all()->random()->getId(),
        ];
        $response = $this->json('PUT', '/action/group/' . $group->getId(), $data);

        $response
            ->assertStatus(404);
    }

    public function test_groups_update_incorrect_group()
    {
        Event::fake();

        $group = Group::factory()->create();

        $data = [
            "name" => "string",
            "children_age" => 10,
            "branch_id" => Branch::all()->random()->getId(),
        ];
        $response = $this->json('PUT', '/action/group/' . -1, $data);

        $response
            ->assertStatus(404);
    }

    public function test_groups_update_null_no_required()
    {
        Event::fake();

        $group = Group::factory()->create();

        $data = [
            "children_age" => 10,
        ];
        $response = $this->json('PUT', '/action/group/' . $group->getId(), $data);

        $response
            ->assertStatus(200);
    }
}
