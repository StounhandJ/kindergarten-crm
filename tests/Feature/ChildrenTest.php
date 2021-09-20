<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\Group;
use App\Models\Types\Institution;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ChildrenTest extends TestCase
{
    public function test_children_limit()
    {
        Child::factory()->count(4)->create();

        $response = $this->json('GET', '/action/children', ["limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    /**
     * Checking pages
     *
     * @return void
     */
    public function test_children_limit_page()
    {
        Child::factory()->count(4)->create();

        $response_one = $this->json('GET', '/action/children', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/children', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_children_show()
    {
        $child = Child::factory()->create();

        $response = $this->json('GET', '/action/children/' . $child->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $child->getId());
    }

    public function test_children_attribute_hidden()
    {
        $child = Child::factory()->create();

        $response = $this->json('GET', '/action/children/' . $child->getId());

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has("records")->
            missingAll(['deleted_at', 'created_at', 'updated_at'])
                ->etc()
            );
    }

    public function test_children_delete()
    {
        $child = Child::factory()->create();

        $response = $this->json('DELETE', '/action/children/' . $child->getId());

        $response->assertStatus(200);
    }

    public function test_children_store()
    {
//        $child = Child::getById(Child::factory()->create()->getId());
//        $this->assertNotNull($child);
        $data = [
            "fio" => "string",
            "address" => "string",
            "fio_mother" => "string",
            "phone_mother" => "string",
            "fio_father" => "string",
            "phone_father" => "string",
            "comment" => "string",
            "rate" => 23,
            "date_exclusion" => Carbon::now(),
            "reason_exclusion" => "string",
            "date_birth" => Carbon::now(),
            "date_enrollment" => Carbon::now(),
            "group_id" => Group::factory()->create()->getId(),
            "institution_id" => Institution::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/children', $data);

        $response
            ->assertStatus(200)
            ->assertJsonPath("records", $data);
    }
}
