<?php

namespace App\Observers;

use App\Models\GeneralJournalChild;
use App\Models\JournalChild;
use App\Models\Types\Visit;

class GeneralJournalChildObserver
{
    /**
     * Handle the GeneralJournalChild "created" event.
     *
     * @param  \App\Models\GeneralJournalChild  $generalJournalChild
     * @return void
     */
    public function created(GeneralJournalChild $generalJournalChild)
    {
        $month = $generalJournalChild->getMonth();
        for ($i = 1; $i <= $month->lastOfMonth()->day; $i++) {
            $journalDateDay = $month->setDay($i);
            if ($month->isWeek() and $generalJournalChild->getChild()->getJournal()->whereDate("create_date", "=", $journalDateDay)->count() == 0) {
                JournalChild::make($generalJournalChild->getChild(), Visit::getById(Visit::NOT_SELECTED), $journalDateDay)->save();
            }
        }
    }
}
