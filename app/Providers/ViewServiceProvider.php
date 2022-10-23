<?php
 
namespace App\Providers;
 
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Models\Legislation;
use App\Models\Comment;

class ViewServiceProvider extends ServiceProvider
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
        View::composer('layouts.navbar', function ($view) 
        {
            
            $appLogo = Setting::where('name', 'appLogo')->first()->value;

            $legislationNotifications = Legislation::inProgress()
                                                    ->get();

            $commentNotifications = Comment::unread()
                                        ->where('to_id', Auth::user()->id)
                                        ->latest()
                                        ->get();
            
            return $view->with('appLogo', $appLogo)
                        ->with('legislationNotifications', $legislationNotifications)
                        ->with('commentNotifications', $commentNotifications);                                                   
        });

        View::composer('layouts.footer', function ($view) 
        {
            $appDesc = Setting::where('name', 'appDesc')->first()->value;
            $appUrl = Setting::where('name', 'appUrl')->first()->value;
            $company = Setting::where('name', 'company')->first()->value;
            $companyUrl = Setting::where('name', 'companyUrl')->first()->value;

            return $view->with('appDesc', $appDesc)
                        ->with('appUrl', $appUrl)
                        ->with('company', $company)
                        ->with('companyUrl', $companyUrl);
        });
    }
}