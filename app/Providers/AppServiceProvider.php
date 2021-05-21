<?php

namespace App\Providers;

use App\Services\SendPulseService;
use App\Services\SmsManager;
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
        $this->app->bind(SmsManager::class, SendPulseService::class);

    }
}
