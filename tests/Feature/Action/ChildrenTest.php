<?php

namespace Tests\Feature\Action;

use App\Models\Child;
use App\Models\Group;
use App\Models\Types\Institution;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
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

    public function test_children_show_remote_child()
    {
        $this->assertDatabaseMissing("children", [
            "id" => 789
        ]);

        $response = $this->json('GET', '/action/children/789');

        $response
            ->assertStatus(404);
    }

    public function test_children_show_incorrect_child()
    {
        $child = Child::factory()->create();

        $response = $this->json('GET', '/action/children/' . -1);

        $response
            ->assertStatus(404);
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

    public function test_children_delete_remote_child()
    {
        $this->assertDatabaseMissing("children", [
            "id" => 789
        ]);

        $response = $this->json('DELETE', '/action/children/789');

        $response->assertStatus(404);
    }

    public function test_children_store()
    {
        Event::fake();
        $data = [
            "fio" => "string",
            "address" => "string",
            "fio_mother" => "string",
            "phone_mother" => "string",
            "fio_father" => null,
            "phone_father" => null,
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
            ->assertStatus(200);
    }

    public function test_children_store_null_required()
    {
        Event::fake();
        $data = [
            "address" => "string",
            "fio_mother" => "string",
            "phone_mother" => "string",
            "comment" => "string",
            "phone_father" => "string",
            "rate" => 23,
            "date_birth" => Carbon::now(),
            "date_enrollment" => Carbon::now(),
            "group_id" => Group::factory()->create()->getId(),
            "institution_id" => Institution::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/children', $data);

        $response
            ->assertStatus(422);
    }

    public function test_children_store_null_no_required()
    {
        Event::fake();
        $data = [
            "fio" => "string",
            "address" => "string",
            "fio_mother" => null,
            "phone_mother" => "string",
            "fio_father" => null,
            "phone_father" => "string",
            "rate" => 23,
            "date_birth" => Carbon::now(),
            "date_enrollment" => Carbon::now(),
            "group_id" => Group::factory()->create()->getId(),
            "institution_id" => Institution::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/children', $data);

        $response
            ->assertStatus(200);
    }

    public function test_children_store_incorrect_group_id()
    {
        Event::fake();
        $data = [
            "fio" => "string",
            "address" => "string",
            "fio_mother" => "string",
            "phone_mother" => "string",
            "fio_father" => null,
            "phone_father" => null,
            "comment" => "string",
            "rate" => 23,
            "date_exclusion" => Carbon::now(),
            "reason_exclusion" => "string",
            "date_birth" => Carbon::now(),
            "date_enrollment" => Carbon::now(),
            "group_id" => -1,
            "institution_id" => Institution::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/children', $data);

        $response
            ->assertStatus(422);
    }


    public function test_children_update()
    {
        Event::fake();

        $child = Child::factory()->create();

        $data = [
            "fio" => "string",
            "address" => "string",
            "fio_mother" => null,
            "phone_mother" => null,
            "fio_father" => null,
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
        $response = $this->json('PUT', '/action/children/' . $child->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_children_update_remote_child()
    {
        Event::fake();

        $child = Child::factory()->create();
        $child->delete();

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
        $response = $this->json('PUT', '/action/children/' . $child->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_children_update_incorrect_child()
    {
        Event::fake();

        $child = Child::factory()->create();

        $data = [
            "fio" => "string",
            "address" => "string",
            "fio_mother" => "string",
            "phone_mother" => "string",
            "fio_father" => null,
            "phone_father" => null,
            "comment" => "string",
            "rate" => 23,
            "date_exclusion" => Carbon::now(),
            "reason_exclusion" => "string",
            "date_birth" => Carbon::now(),
            "date_enrollment" => Carbon::now(),
            "group_id" => Group::factory()->create()->getId(),
            "institution_id" => Institution::all()->random()->getId(),
        ];
        $response = $this->json('PUT', '/action/children/' . -1, $data);

        $response
            ->assertStatus(404);
    }

    public function test_children_update_null_no_required()
    {
        Event::fake();

        $child = Child::factory()->create();

        $data = [
            "fio" => "string",
            "address" => "string",
            "fio_mother" => "string",
            "phone_mother" => "string",
            "fio_father" => "string",
            "phone_father" => "string",
            "comment" => "string",
        ];
        $response = $this->json('PUT', '/action/children/' . $child->getId(), $data);

        $response
            ->assertStatus(200);
    }
}
