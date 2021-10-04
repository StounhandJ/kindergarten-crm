<?php

namespace Tests\Feature\Action;

use App\Models\Branch;
use App\Models\Child;
use App\Models\Cost\Cost;
use App\Models\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CostTest extends TestCase
{
    public function test_cost_limit_profit()
    {
        Cost::factory()->profit()->count(4)->create();

        $response = $this->json('GET', '/action/cost', ["income" => 1, "limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    public function test_cost_limit_losses()
    {
        Cost::factory()->losses()->count(4)->create();

        $response = $this->json('GET', '/action/cost', ["income" => 0, "limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    /**
     * Checking pages
     *
     * @return void
     */
    public function test_costs_limit_page()
    {
        Cost::factory()->profit()->count(4)->create();

        $response_one = $this->json('GET', '/action/cost', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/cost', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_cost_show()
    {
        $cost = Cost::factory()->profit()->create();

        $response = $this->json('GET', '/action/cost/' . $cost->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $cost->getId());
    }

    public function test_cost_staff_show()
    {
        $staff = Staff::factory()->create();
        $cost = Cost::profit(100, "f", new Child(), $staff, Carbon::now());

        $response = $this->json('GET', '/action/cost/' . $cost->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $cost->getId())
            ->assertJsonPath("records.staff.id", $staff->getId());
    }

    public function test_cost_child_show()
    {
        $child = Child::factory()->create();
        $cost = Cost::profit(100, "f", $child, new Staff(), Carbon::now());

        $response = $this->json('GET', '/action/cost/' . $cost->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $cost->getId())
            ->assertJsonPath("records.child.id", $child->getId());
    }

    public function test_cost_show_incorrect_cost()
    {
        Cost::factory()->profit()->create();

        $response = $this->json('GET', '/action/cost/' . -1);

        $response
            ->assertStatus(404);
    }

    public function test_cost_staff_profit_store()
    {
        $data = [
            "amount" => 100,
            "comment" => "ffff",
            "staff_id" => Staff::factory()->create()->getId(),
            "income" => 1,
            "month" => Carbon::now()->addMonths(-2)
        ];
        $response = $this->json('POST', '/action/cost', $data);

        $response
            ->assertStatus(200);
    }

    public function test_cost_staff_losses_store()
    {
        $data = [
            "amount" => 100,
            "comment" => "ffff",
            "staff_id" => Staff::factory()->create()->getId(),
            "income" => 0
        ];
        $response = $this->json('POST', '/action/cost', $data);

        $response
            ->assertStatus(200);
    }

    public function test_cost_child_profit_store()
    {
        $data = [
            "amount" => 100,
            "comment" => "ffff",
            "child_id" => Child::factory()->create()->getId(),
            "income" => 1,
            "month" => Carbon::now()
        ];
        $response = $this->json('POST', '/action/cost', $data);

        $response
            ->assertStatus(200);
    }

    public function test_cost_child_losses_store()
    {
        $data = [
            "amount" => 100,
            "comment" => "ffff",
            "child_id" => Child::factory()->create()->getId(),
            "income" => 0,
            "month" => Carbon::now()
        ];
        $response = $this->json('POST', '/action/cost', $data);

        $response
            ->assertStatus(200);
    }

    public function test_cost_store_no_required()
    {
        $data = [
            "comment" => "ffff",
            "child_id" => Child::factory()->create()->getId(),
            "income" => 0
        ];
        $response = $this->json('POST', '/action/cost', $data);

        $response
            ->assertStatus(422);
    }

    public function test_cost_cash()
    {
        $expected = -200;

        Cost::factory([
            "amount"=>100,
            "is_profit"=>true
        ])->create();
        Cost::factory([
            "amount"=>300,
            "is_profit"=>true
        ])->create();
        Cost::factory([
            "amount"=>600,
            "is_profit"=>false
        ])->create();

        $response = $this->json('GET', '/action/cost-cash');

        $response
            ->assertStatus(200)
            ->assertJsonPath("amount", $expected);
    }
}
