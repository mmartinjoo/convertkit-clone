<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Mail::alwaysTo('m4rt1n.j00@gmail.com');
//         DB::listen(function ($query) {
//             logger(Str::replaceArray('?', $query->bindings, $query->sql));
//         });
    }
}
