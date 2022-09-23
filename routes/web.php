<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard');

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $enableViews = config('fortify.views', true);

    // Authentication...
    if ($enableViews) {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('login');
    }

    $limiter = config('fortify.limiters.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:'.config('fortify.guard'),
            $limiter ? 'throttle:'.$limiter : null,
        ]));

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

});

Route::middleware('auth')->group(function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('user', UserController::class);
    Route::controller(UserController::class)->group(function () {
        Route::post('/user/trigger', 'trigger')->name('user.trigger');
        Route::put('/user/{user}/restore', 'restore')->name('user.restore');
        Route::delete('/user/{user}/force-destroy', 'forceDestroy')->name('user.force-destroy');
        Route::put('/user/{user}/delete-avatar', 'deleteAvatar')->name('user.delete-avatar');
        Route::put('/user/{user}/set-new-password', 'setNewPassword')->name('user.set-new-password');
    });

});