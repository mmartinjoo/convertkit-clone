<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Str;

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
//         DB::listen(function ($query) {
//             logger(Str::replaceArray('?', $query->bindings, $query->sql));
//         });
    }
}
