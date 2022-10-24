<?php
 
namespace App\Providers;
 
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Models\Legislation;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

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
            
            $appLogo = Setting::where('key', 'appLogo')->first()->value;
            $appLogoUrl = (Storage::disk('public')->exists($appLogo)) ? Storage::url($appLogo) : '/assets/images/logo_icon.svg';

            $legislationNotifications = Legislation::inProgress()
                                                    ->get();

            $commentNotifications = Comment::unread()
                                        ->where('to_id', Auth::user()->id)
                                        ->latest()
                                        ->get();
            
            return $view->with('appLogoUrl', $appLogoUrl)
                        ->with('legislationNotifications', $legislationNotifications)
                        ->with('commentNotifications', $commentNotifications);                                                   
        });

        View::composer('layouts.footer', function ($view) 
        {
            $appDesc = Setting::where('key', 'appDesc')->first()->value;
            $appUrl = Setting::where('key', 'appUrl')->first()->value;
            $company = Setting::where('key', 'company')->first()->value;
            $companyUrl = Setting::where('key', 'companyUrl')->first()->value;

            return $view->with('appDesc', $appDesc)
                        ->with('appUrl', $appUrl)
                        ->with('company', $company)
                        ->with('companyUrl', $companyUrl);
        });
    }
}