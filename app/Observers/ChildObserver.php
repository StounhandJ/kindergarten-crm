<?php

namespace App\Observers;

use App\Models\Child;
use App\Models\GeneralJournalChild;
use Illuminate\Support\Carbon;

class ChildObserver
{
    /**
     * Handle the Child "created" event.
     *
     * @param Child $child
     * @return void
     */
    public function created(Child $child)
    {
        $generalJournalChild = GeneralJournalChild::make($child, Carbon::now());
        $generalJournalChild->save();
    }
}
