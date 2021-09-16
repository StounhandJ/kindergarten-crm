<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PositionServiceProvider extends ServiceProvider
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
        Blade::if('position', function ($roles){
            if (is_null(auth()->user()))
                return false;

            if (is_string($roles))
                return auth()->user()->checkPosition($roles);

            if (is_array($roles))
            {
                foreach ($roles as $role)
                {
                    if (auth()->user()->checkPosition($role))
                        return true;
                }
            }
            return false;
        });
    }
}
