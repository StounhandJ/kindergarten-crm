<?php

namespace Tests\Feature\Action;

use App\Models\Branch;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BranchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_base_branch()
    {
        $response = $this->getJson('/action/branch-array');

        $response
            ->assertStatus(200)
            ->assertExactJson(
                [
                    ["id"=>1, "name"=>"Первый"],
                    ["id"=>2, "name"=>"Второй"]
                ]
            );
    }

    public function test_branches_limit()
    {
        Branch::factory()->count(4)->create();

        $response = $this->json('GET', '/action/branches', ["limit" => 3]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "records");
    }

    /**
     * Checking pages
     *
     * @return void
     */
    public function test_branches_limit_page()
    {
        Branch::factory()->count(4)->create();

        $response_one = $this->json('GET', '/action/branches', ["limit" => 3, "page" => 1]);
        $response_two = $this->json('GET', '/action/branches', ["limit" => 2, "page" => 2]);

        $response_one->assertJsonPath("records.2", $response_two->json("records.0"));
    }

    public function test_branches_show()
    {
        $branch = Branch::factory()->create();

        $response = $this->json('GET', '/action/branches/' . $branch->getId());

        $response
            ->assertStatus(200)
            ->assertJsonPath("records.id", $branch->getId());
    }

    public function test_branches_show_incorrect_child()
    {
        Branch::factory()->create();

        $response = $this->json('GET', '/action/branches/' . -1);

        $response
            ->assertStatus(404);
    }

    public function test_branches_delete()
    {
        $branch = Branch::factory()->create();

        $response = $this->json('DELETE', '/action/branches/' . $branch->getId());

        $response->assertStatus(200);
    }

    public function test_branches_delete_remote_child()
    {
        $this->assertDatabaseMissing("branches", [
            "id"=>789
        ]);

        $response = $this->json('DELETE', '/action/branches/789');

        $response->assertStatus(404);
    }

    public function test_branches_store()
    {
        Event::fake();
        $data = [
            "name" => "string"
        ];
        $response = $this->json('POST', '/action/branches', $data);

        $response
            ->assertStatus(200);
    }

    public function test_branches_store_null_required()
    {
        Event::fake();
        $data = [

        ];
        $response = $this->json('POST', '/action/branches', $data);

        $response
            ->assertStatus(422);
    }

    public function test_branches_update()
    {
        Event::fake();

        $branch = Branch::factory()->create();

        $data = [
            "name" => "string"
        ];
        $response = $this->json('PUT', '/action/branches/' . $branch->getId(), $data);

        $response
            ->assertStatus(200);
    }

    public function test_branches_update_incorrect_child()
    {
        Event::fake();

        Branch::factory()->create();

        $data = [
            "name" => "string"
        ];
        $response = $this->json('PUT', '/action/branches/' . -1, $data);

        $response
            ->assertStatus(404);
    }

    public function test_branches_update_null_no_required()
    {
        Event::fake();

        $branch = Branch::factory()->create();

        $data = [
            "name" => "string"
        ];
        $response = $this->json('PUT', '/action/branches/' . $branch->getId(), $data);

        $response
            ->assertStatus(200);
    }

}
