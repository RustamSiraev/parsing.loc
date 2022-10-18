<?php

namespace App\Providers;

//use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Pagination\Paginator;
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
//        if ($this->app->isLocal()) {
//            $this->app->register(Debugbar::class);
//        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.debug')!=true) {
            \URL::forceScheme('https');
        }
        Paginator::defaultView('pagination');
        Paginator::defaultSimpleView('simple-pagination');
    }
}
