<?php

namespace App\Providers;

use App\Models\Child;
use App\Models\GeneralJournalChild;
use App\Models\GeneralJournalStaff;
use App\Models\Staff;
use App\Observers\ChildObserver;
use App\Observers\GeneralJournalChildObserver;
use App\Observers\GeneralJournalStaffObserver;
use App\Observers\StaffObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        GeneralJournalChild::observe(GeneralJournalChildObserver::class);
        GeneralJournalStaff::observe(GeneralJournalStaffObserver::class);
        Child::observe(ChildObserver::class);
        Staff::observe(StaffObserver::class);
    }
}
