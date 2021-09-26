<?php

namespace Tests\Feature\Action;


use App\Models\Group;
use App\Models\Staff;
use App\Models\Types\Institution;
use App\Models\Types\Position;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StaffTest extends TestCase
{
    public function test_staff_limit()
    {
        Staff::factory()->count(4)->create();

        $response = $this->json('GET', '/action/staff', ["limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    /**
     * Checking pages
     *
     * @return void
     */
    public function test_staff_limit_page()
    {
        Staff::factory()->count(4)->create();

        $response_one = $this->json('GET', '/action/staff', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/staff', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_staff_show()
    {
        $staff = Staff::factory()->create();

        $response = $this->json('GET', '/action/staff/' . $staff->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $staff->getId());
    }

    public function test_staff_show_remote_staff()
    {
        $this->assertDatabaseMissing("staff", [
            "id" => 789
        ]);

        $response = $this->json('GET', '/action/staff/789');

        $response
            ->assertStatus(404);
    }

    public function test_staff_show_incorrect_staff()
    {
        $staff = Staff::factory()->create();

        $response = $this->json('GET', '/action/staff/' . -1);

        $response
            ->assertStatus(404);
    }

    public function test_staff_attribute_hidden()
    {
        $staff = Staff::factory()->create();

        $response = $this->json('GET', '/action/staff/' . $staff->getId());

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has("records")->
            missingAll(['deleted_at', 'created_at', 'updated_at'])
                ->etc()
            );
    }

    public function test_staff_delete()
    {
        $staff = Staff::factory()->create();

        $response = $this->json('DELETE', '/action/staff/' . $staff->getId());

        $response->assertStatus(200);
    }

    public function test_staff_delete_remote_staff()
    {
        $this->assertDatabaseMissing("staff", [
            "id" => 789
        ]);

        $response = $this->json('DELETE', '/action/staff/789');

        $response->assertStatus(404);
    }

    public function test_staff_store()
    {
        Event::fake();
        $data = [
            "fio" => "string",
            "login" => "string",
            "password" => "string",
            "address" => "string",
            "phone" => "string",
            "date_birth" =>  Carbon::now(),
            "date_employment" => Carbon::now(),
            "date_dismissal" => Carbon::now(),
            "reason_dismissal" => "string",
            "salary" => 325,
            "group_id" => Group::factory()->create()->getId(),
            "position_id" => Position::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/staff', $data);

        $response
            ->assertStatus(200);
    }

    public function test_staff_store_null_required()
    {
        Event::fake();
        $data = [
            "fio" => "string",
            "login" => "string",
            "password" => "string",
            "address" => "string",
            "date_employment" => Carbon::now(),
            "date_dismissal" => Carbon::now(),
            "reason_dismissal" => "string",
            "salary" => 325,
            "group_id" => Group::factory()->create()->getId(),
            "position_id" => Position::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/staff', $data);

        $response
            ->assertStatus(422);
    }

    public function test_staff_store_null_no_required()
    {
        Event::fake();
        $data = [
            "fio" => "string",
            "login" => "string",
            "password" => "string",
            "address" => "string",
            "phone" => "string",
            "date_birth" =>  Carbon::now(),
            "date_employment" => Carbon::now(),
            "salary" => 325,
            "group_id" => Group::factory()->create()->getId(),
            "position_id" => Position::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/staff', $data);

        $response
            ->assertStatus(200);
    }

    public function test_staff_store_nullable_group_id()
    {
        Event::fake();
        $data = [
            "fio" => "string",
            "login" => "string",
            "password" => "string",
            "address" => "string",
            "phone" => "string",
            "date_birth" =>  Carbon::now(),
            "date_employment" => Carbon::now(),
            "salary" => 325,
            "group_id" => null,
            "position_id" => Position::all()->random()->getId(),
        ];
        $response = $this->json('POST', '/action/staff', $data);

        $response
            ->assertStatus(200);
    }


    public function test_staff_update()
    {
        Event::fake();

        $staff = Staff::factory()->create();

        $data = [
            "fio" => "string",
            "login" => "string",
            "password" => "string",
            "address" => "string",
            "phone" => "string",
            "date_birth" =>  Carbon::now(),
            "date_employment" => Carbon::now(),
            "date_dismissal" => Carbon::now(),
            "reason_dismissal" => "string",
            "salary" => 325,
            "group_id" => Group::factory()->create()->getId(),
            "position_id" => Position::all()->random()->getId(),
        ];
        $response = $this->json('PUT', '/action/staff/' . $staff->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_staff_update_nullable_group_id()
    {
        Event::fake();

        $staff = Staff::factory()->create();

        $data = [
            "fio" => "string",
            "login" => "string",
            "group_id" => null,
            "position_id" => Position::all()->random()->getId(),
        ];
        $response = $this->json('PUT', '/action/staff/' . $staff->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_staff_update_remote_staff()
    {
        Event::fake();

        $staff = Staff::factory()->create();
        $staff->delete();

        $data = [
            "fio" => "string",
            "login" => "string",
            "password" => "string",
            "address" => "string",
            "phone" => "string",
            "date_birth" =>  Carbon::now(),
            "date_employment" => Carbon::now(),
            "date_dismissal" => Carbon::now(),
            "reason_dismissal" => "string",
            "salary" => 325,
            "group_id" => Group::factory()->create()->getId(),
            "position_id" => Position::all()->random()->getId(),
        ];
        $response = $this->json('PUT', '/action/staff/' . $staff->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_staff_update_incorrect_staff()
    {
        Event::fake();

        $staff = Staff::factory()->create();

        $data = [
            "fio" => "string",
            "login" => "string",
            "password" => "string",
            "address" => "string",
            "phone" => "string",
            "date_birth" =>  Carbon::now(),
            "date_employment" => Carbon::now(),
            "date_dismissal" => Carbon::now(),
            "reason_dismissal" => "string",
            "salary" => 325,
            "group_id" => Group::factory()->create()->getId(),
            "position_id" => Position::all()->random()->getId(),
        ];
        $response = $this->json('PUT', '/action/staff/' . -1, $data);

        $response
            ->assertStatus(404);
    }

    public function test_staff_update_null_no_required()
    {
        Event::fake();

        $staff = Staff::factory()->create();

        $data = [
            "fio" => "string",
            "login" => "string",
            "password" => "string",
            "address" => "string",
            "phone" => "string",
        ];
        $response = $this->json('PUT', '/action/staff/' . $staff->getId(), $data);

        $response
            ->assertStatus(200);
    }
}
