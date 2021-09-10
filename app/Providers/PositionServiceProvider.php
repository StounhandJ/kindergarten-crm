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
        Blade::directive('position', function ($role){
            return "<?php if(auth()->user()->checkPosition({$role})): ?>";
        });
        Blade::directive('endrole', function ($role){
            return "<?php endif; ?>";
        });
    }
}
