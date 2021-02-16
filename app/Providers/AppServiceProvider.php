<?php

namespace App\Providers;

use App\Models\Absence;
use App\Models\User;
use App\Observers\AbsencesObserve;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        User::observe(UserObserver::class);
        Absence::observe(AbsencesObserve::class);
    }
}
