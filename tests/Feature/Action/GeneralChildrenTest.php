<?php

namespace Tests\Feature\Action;

use App\Models\Child;
use App\Models\GeneralJournalChild;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class GeneralChildrenTest extends TestCase
{
    public function test_general_children_limit()
    {
        Child::factory()->count(4)->create();

        $response = $this->json('GET', '/action/general-journal-child', ["limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    public function test_general_children_limit_page()
    {
        Child::factory()->count(4)->create();

        $response_one = $this->json('GET', '/action/general-journal-child', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/general-journal-child', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_general_children_update()
    {
        Child::factory()->create();
        $gen = GeneralJournalChild::all()->random();

        $data = [
            "reduction_fees" => 0,
            "increase_fees" => 100,
            "comment" => "string",
            "notification" => false
        ];
        $response = $this->json('PUT', '/action/general-journal-child/' . $gen->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_general_children_update_incorrect()
    {
        Child::factory()->create();
        $gen = GeneralJournalChild::all()->random();

        $data = [
            "reduction_fees" => 0,
            "increase_fees" => "al",
            "comment" => "string",
            "notification" => "ddd"
        ];
        $response = $this->json('PUT', '/action/general-journal-child/' . $gen->getId(), $data);

        $response
            ->assertStatus(422);
    }

    public function test_general_children_update_null_no_required()
    {
        Child::factory()->create();
        $gen = GeneralJournalChild::all()->random();

        $data = [
            "comment" => "string",
            "notification" => false
        ];
        $response = $this->json('PUT', '/action/general-journal-child/' . $gen->getId(), $data);

        $response
            ->assertStatus(200);
    }
}
