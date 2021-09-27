<?php

namespace Tests\Feature\Action;

use App\Models\Child;
use Tests\TestCase;

class JournalChildrenTest extends TestCase
{
    public function test_journal_children()
    {
        Child::factory()->count(4)->create();
        $response = $this->get('/action/journal-children');

        $response
            ->assertStatus(200)
            ->assertJsonCount(4, "children");
    }
}
