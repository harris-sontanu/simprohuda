<?php
 
namespace App\Providers;
 
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
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
        View::composer('layouts.navbar', function ($view) {
            $legislationNotifications = Legislation::processed()
                                                    ->get();

            $commentNotifications = Comment::unread()
                                        ->where('to_id', Auth::user()->id)
                                        ->latest()
                                        ->get();
            
            return $view->with('legislationNotifications', $legislationNotifications)
                        ->with('commentNotifications', $commentNotifications);                                                   
        });
    }
}