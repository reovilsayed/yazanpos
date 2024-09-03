<?php

namespace App\Providers;

use App\Facades\Settings\Settings;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        app()->bind('settings', function () {  //Keep in mind this "check" must be return from facades accessor
            return new Settings;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
