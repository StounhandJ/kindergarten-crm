<?php

namespace Tests\Feature\Action;

use App\Models\Branch;
use App\Models\Child;
use App\Models\Cost\CategoryCost;
use App\Models\Cost\Cost;
use App\Models\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CostTest extends TestCase
{
    private CategoryCost $category_staff_losses;
    private CategoryCost $category_staff_profit;
    private CategoryCost $category_child_profit;
    private CategoryCost $category_child_losses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category_staff_losses = CategoryCost::factory([
            "name" => "Staff Losses", "is_profit" => false, "is_set_child"=>false, "is_set_staff" => true
        ])->create();
        $this->category_staff_profit = CategoryCost::factory([
            "name" => "Staff Profit", "is_profit" => true, "is_set_child"=>false, "is_set_staff" => true
        ])->create();
        $this->category_child_profit = CategoryCost::factory([
            "name" => "Child Profit", "is_profit" => true, "is_set_child"=>true, "is_set_staff" => false
        ])->create();
        $this->category_child_losses = CategoryCost::factory([
            "name" => "Child Losses", "is_profit" => false, "is_set_child"=>true, "is_set_staff" => false
        ])->create();
    }

    public function test_cost_limit_profit()
    {
        Cost::factory(["category_id"=>$this->category_staff_profit->getId()])->count(4)->create();

        $response = $this->json('GET', '/action/cost', ["income" => 1, "limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    public function test_cost_limit_losses()
    {
        Cost::factory(["category_id"=>$this->category_staff_losses->getId()])->count(4)->create();

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
        Cost::factory()->count(4)->create();

        $response_one = $this->json('GET', '/action/cost', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/cost', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_cost_show()
    {
        $cost = Cost::factory()->create();

        $response = $this->json('GET', '/action/cost/' . $cost->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $cost->getId());
    }

    public function test_cost_staff_show()
    {
        $staff = Staff::factory()->create();
        $cost = Cost::create($this->category_staff_profit, 100, "f", new Child(), $staff, Carbon::now());

        $response = $this->json('GET', '/action/cost/' . $cost->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $cost->getId())
            ->assertJsonPath("records.staff.id", $staff->getId());
    }

    public function test_cost_child_show()
    {
        $child = Child::factory()->create();
        $cost = Cost::create($this->category_child_profit, 100, "f", $child, new Staff(), Carbon::now());

        $response = $this->json('GET', '/action/cost/' . $cost->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $cost->getId())
            ->assertJsonPath("records.child.id", $child->getId());
    }

    public function test_cost_show_incorrect_cost()
    {
        Cost::factory()->create();

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
            "category_id" => $this->category_staff_profit->getId(),
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
            "category_id" => $this->category_staff_losses->getId(),
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
            "category_id" => $this->category_child_profit->getId(),
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
            "category_id" => $this->category_child_losses->getId(),
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
            "category_id" => $this->category_child_losses->getId(),
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
            "category_id"=>$this->category_child_profit->getId()
        ])->create();
        Cost::factory([
            "amount"=>300,
            "category_id"=>$this->category_child_profit->getId()
        ])->create();
        Cost::factory([
            "amount"=>600,
            "category_id"=>$this->category_staff_losses->getId()
        ])->create();

        $response = $this->json('GET', '/action/cost-cash');

        $response
            ->assertStatus(200)
            ->assertJsonPath("amount", $expected);
    }
}
