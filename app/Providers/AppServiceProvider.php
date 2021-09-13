<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale("ru");
        Carbon::macro('weekDays', function () {
            $month = $this->month;
            $days = [];
            $this->firstOfMonth();
            while ($month==$this->month)
            {
                if ($this->isWeekday())
                    $days[] = $this->day;
                $this->addDay();
            }
            $this->setMonth($month);
            return $days;
        });

        Carbon::macro('countWeekDays', function () {
            return count($this->weekDays());
        });

        Carbon::macro('isWeek', function () {
            return $this->isWeekday();
        });
    }
}
