<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class CarbonProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale("ru");
        Carbon::macro('weekDays', function ($current_date = false) {
            /** @var Carbon $this */
            $date = $this->clone();

            $month = $date->month;
            if (!$current_date)
                $date->lastOfMonth();

            $days = [];
            while ($month == $date->month) {
                if ($date->isWeekday()) {
                    $days[] = $date->clone();
                }
                $date->addDay(-1);
            }

            return $days;
        });

        Carbon::macro('countWeekDays', function ($current_date = false) {
            /** @var Carbon $this */
            return count($this->weekDays($current_date));
        });

        Carbon::macro('isWeek', function () {
            /** @var Carbon $this */
            return $this->isWeekday();
        });

        Carbon::macro('dateName', function ($reduction = false, $day = true) {
            /** @var Carbon $this */
            $months = [
                "Января",
                "Февраля",
                "Марта",
                "Апреля",
                "Мая",
                "Июня",
                "Июля",
                "Августа",
                "Сентября",
                "Октября",
                "Ноября",
                "Декабря"
            ];
            return sprintf(
                $this->format(($day ? "\"d\" " : "") . "%\s Y %\s"),
                $months[$this->month - 1],
                ($reduction ? "г." : "года")
            );
        });
    }
}
