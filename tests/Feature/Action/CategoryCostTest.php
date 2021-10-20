<?php

namespace Tests\Feature\Action;

use App\Models\Cost\CategoryCost;
use Tests\TestCase;

class CategoryCostTest extends TestCase
{
    public function test_category_cost_limit()
    {
        CategoryCost::factory()->count(4)->create();

        $response = $this->json('GET', '/action/category-cost', ["limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    /**
     * Checking pages
     *
     * @return void
     */
    public function test_category_cost_limit_page()
    {
        CategoryCost::factory()->count(4)->create();

        $response_one = $this->json('GET', '/action/category-cost', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/category-cost', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_category_cost_array()
    {
        CategoryCost::factory()->count(2)->create();

        $response = $this->json('GET', '/action/category-cost-array');

        $response
            ->assertStatus(200)
            ->assertJsonCount(4);
    }

    public function test_category_cost_array_not_active()
    {
        CategoryCost::factory()->create();
        CategoryCost::factory(["is_active" => false])->create();

        $response = $this->json('GET', '/action/category-cost-array');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_category_cost_store()
    {
        $data = [
            "name" => "string",
            "is_profit" => "false",
            "is_set_child" => "true",
            "is_set_staff" => "false"
        ];
        $response = $this->json('POST', '/action/category-cost', $data);

        $response
            ->assertStatus(200);
    }

    public function test_category_cost_store_incorrect()
    {
        $data = [
            "name" => "string",
            "is_profit" => "false",
            "is_set_child" => "fjjjj"
        ];
        $response = $this->json('POST', '/action/category-cost', $data);

        $response
            ->assertStatus(422);
    }

    public function test_category_cost_store_null_required()
    {
        $data = [
            "is_set_child" => "true",
            "is_set_staff" => "false"
        ];
        $response = $this->json('POST', '/action/category-cost', $data);

        $response
            ->assertStatus(422);
    }

    public function test_category_cost_update()
    {
        $category_cost = CategoryCost::factory()->create();

        $data = [
            "name" => "string",
            "is_profit" => "false",
            "is_set_child" => "true",
            "is_set_staff" => "false"
        ];
        $response = $this->json('PUT', '/action/category-cost/' . $category_cost->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_category_cost_update_incorrect()
    {
        CategoryCost::factory()->create();

        $data = [
            "is_profit" => "ghkkk"
        ];
        $response = $this->json('PUT', '/action/category-cost/' . -1, $data);

        $response
            ->assertStatus(404);
    }

    public function test_category_cost_update_incorrect_data()
    {
        $category_cost = CategoryCost::factory()->create();
        CategoryCost::factory()->create();

        $data = [
            "is_profit" => "ghkkk"
        ];
        $response = $this->json('PUT', '/action/category-cost/' . $category_cost->getId(), $data);

        $response
            ->assertStatus(422);
    }

    public function test_category_cost_update_null_no_required()
    {
        $category_cost = CategoryCost::factory()->create();

        $data = [
            "is_set_staff" => "false"
        ];
        $response = $this->json('PUT', '/action/category-cost/' . $category_cost->getId(), $data);

        $response
            ->assertStatus(200);
    }
}
