<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

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
        Filament::serving(function () {
            if (! tenancy()->initialized && request()->getHost() !== config('tenancy.central_domains')[0]) {
                app(InitializeTenancyByDomain::class)->handle(request(), fn($r) => $r);
            }
        });
    }
}
