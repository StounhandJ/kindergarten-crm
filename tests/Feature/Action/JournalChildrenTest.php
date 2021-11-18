<?php

namespace Tests\Feature\Action;

use App\Models\Child;
use App\Models\Group;
use App\Models\Staff;
use App\Models\Types\Position;
use Tests\TestCase;

class JournalChildrenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $group = Group::factory()->create();
        Child::factory(["group_id"=>$group->getId()])->count(4)->create();
        $staff = Staff::factory(["group_id"=>$group->getId(), "position_id"=> Position::getById(Position::SENIOR_TUTOR)])->create();
        $this->actingAs($staff->getUser());
    }

    public function test_journal_children()
    {

        $response = $this->get('/action/journal-children');

        $response
            ->assertStatus(200)
            ->assertJsonCount(4, "children");
    }
}
