<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('local')) {
            Artisan::call('migrate --seed');
            if (!Schema::hasTable('models') || !Schema::hasTable('models')) {
                Artisan::call('update:car-models');
                Artisan::call('update:car-makes');
            }


        }
    }
}
