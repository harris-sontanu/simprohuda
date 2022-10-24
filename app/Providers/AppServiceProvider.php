<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

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
        $appName = config('app.name');
        if (Schema::hasTable('settings')) {
            $appName = Setting::where('key', 'appName')->first()->value;
        }
        View::share('appName', $appName);
        
        Paginator::useBootstrapFour();
    }
}
