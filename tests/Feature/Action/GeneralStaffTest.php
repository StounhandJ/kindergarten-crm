<?php

namespace Tests\Feature\Action;

use App\Models\GeneralJournalStaff;
use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeneralStaffTest extends TestCase
{
    public function test_general_staff_limit()
    {
        staff::factory()->count(4)->create();

        $response = $this->json('GET', '/action/general-journal-staff', ["limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    public function test_general_staff_limit_page()
    {
        staff::factory()->count(4)->create();

        $response_one = $this->json('GET', '/action/general-journal-staff', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/general-journal-staff', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_general_staff_update()
    {
        Staff::factory()->create();
        $gen = GeneralJournalStaff::all()->random();

        $data = [
            "advance_payment" => 0,
            "reduction_salary" => 100,
            "increase_salary" => 100,
            "comment" => "string"
        ];
        $response = $this->json('PUT', '/action/general-journal-staff/' . $gen->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_general_staff_update_incorrect()
    {
        Staff::factory()->create();
        $gen = GeneralJournalStaff::all()->random();

        $data = [
            "advance_payment" => 0,
            "reduction_salary" => "fsdf",
            "increase_salary" => 100,
            "comment" => false
        ];
        $response = $this->json('PUT', '/action/general-journal-staff/' . $gen->getId(), $data);

        $response
            ->assertStatus(422);
    }

    public function test_general_staff_update_null_no_required()
    {
        Staff::factory()->create();
        $gen = GeneralJournalStaff::all()->random();

        $data = [
            "advance_payment" => 0,
            "comment" => "string"
        ];
        $response = $this->json('PUT', '/action/general-journal-staff/' . $gen->getId(), $data);

        $response
            ->assertStatus(200);
    }
}
