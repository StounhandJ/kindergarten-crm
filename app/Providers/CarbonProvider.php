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
        Carbon::macro('weekDays', function () {
            /** @var Carbon $this */
            $month = $this->month;
            $days = [];
            $this->firstOfMonth();
            while ($month == $this->month) {
                if ($this->isWeekday()) {
                    $days[] = $this->clone();
                }
                $this->addDay();
            }
            $this->setMonth($month);
            return $days;
        });

        Carbon::macro('countWeekDays', function () {
            /** @var Carbon $this */
            return count($this->weekDays());
        });

        Carbon::macro('isWeek', function () {
            /** @var Carbon $this */
            return $this->isWeekday();
        });

        Carbon::macro('dateName', function ($reduction = false) {
            /** @var Carbon $this */
            $months = [
                "Января",
                "Февраля",
                "Марта",
                "Апреля",
                "Мая",
                "Июня",
                "Июля",
                "Июня",
                "Августа",
                "Сентября",
                "Октября",
                "Ноября",
                "Декабря"
            ];
            return sprintf($this->format("\"d\" %\s Y ".($reduction?"г.":"года")), $months[$this->month]);
        });
    }
}
