<?php

namespace App\Observers;

use App\Models\GeneralJournalStaff;
use App\Models\JournalStaff;
use App\Models\Types\Visit;

class GeneralJournalStaffObserver
{
    /**
     * Handle the GeneralJournalStaff "created" event.
     *
     * @param GeneralJournalStaff $generalJournalStaff
     * @return void
     */
    public function created(GeneralJournalStaff $generalJournalStaff)
    {
        $month = $generalJournalStaff->getMonth();
        for ($i = 1; $i <= $month->lastOfMonth()->day; $i++) {
            $journalDateDay = $month->setDay($i);
            if ($month->isWeek() and $generalJournalStaff->getStaff()->getJournal()->whereDate("create_date", "=", $journalDateDay)->count() == 0) {
                JournalStaff::make($generalJournalStaff->getStaff(), Visit::getById(Visit::NOT_SELECTED), $journalDateDay)->save();
            }
        }
    }
}
