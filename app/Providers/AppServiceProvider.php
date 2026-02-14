<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        // Eger settings tablitsasy bar bolsa
        if (Schema::hasTable('settings')) {
            $setting = DB::table('settings')->first();
            View::share('setting', $setting);
        }
    }
}
