<?php
 
namespace App\Providers;
 
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Legislation;
 
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
            $legislationNotifications = Legislation::where(function ($query) {
                                                        $query->whereNotNull('posted_at')
                                                            ->orWhereNotNull('revised_at');
                                                    })
                                                    ->whereNull('validated_at')
                                                    ->orderBy('posted_at', 'desc')
                                                    ->get();
            
            return $view->with('legislationNotifications', $legislationNotifications);                                                   
        });
    }
}