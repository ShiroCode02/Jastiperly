<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserDetail;
use App\Observers\UserObserver;
use App\Observers\UserDetailObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

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
        Carbon::setLocale('id');
        App::setLocale('id');
        
        User::observe(UserObserver::class);
        UserDetail::observe(UserDetailObserver::class);
    }
}
