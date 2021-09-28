<?php

namespace Tests\Feature\Action;

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JournalStaffTest extends TestCase
{

    public function test_journal_staffs()
    {
        Staff::factory()->count(4)->create();
        $response = $this->get('/action/journal-staffs');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, "staff");
    }
}
