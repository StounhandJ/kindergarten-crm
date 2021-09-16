<?php

namespace App\Observers;

use App\Models\GeneralJournalStaff;
use App\Models\Staff;
use Illuminate\Support\Carbon;

class StaffObserver
{
    /**
     * Handle the Staff "created" event.
     *
     * @param Staff $staff
     * @return void
     */
    public function created(Staff $staff)
    {
        $generalJournalChild = GeneralJournalStaff::make($staff, Carbon::now());
        $generalJournalChild->save();
    }
}
