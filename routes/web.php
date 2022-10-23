<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Legislation\RanperdaController;
use App\Http\Controllers\Legislation\RanperbupController;
use App\Http\Controllers\Legislation\RanskController;
use App\Http\Controllers\Legislation\DocumentController;
use App\Http\Controllers\Legislation\CommentController;
use App\Http\Controllers\Legislation\LegislationController;
use App\Http\Controllers\SettingController;

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
    Route::post('/dashboard/pie-chart', [DashboardController::class, 'pieChart'])
        ->name('dashboard.pie-chart');

    Route::resource('user', UserController::class);
    Route::controller(UserController::class)->group(function () {
        Route::post('/user/trigger', 'trigger')->name('user.trigger');
        Route::put('/user/{user}/restore', 'restore')->name('user.restore');
        Route::delete('/user/{user}/force-destroy', 'forceDestroy')->name('user.force-destroy');
        Route::put('/user/{user}/delete-avatar', 'deleteAvatar')->name('user.delete-avatar');
        Route::put('/user/{user}/set-new-password', 'setNewPassword')->name('user.set-new-password');
    });

    Route::resource('institute', InstituteController::class);

    Route::name('legislation.')->group(function () {
        Route::resource('/legislation/ranperda', RanperdaController::class);
        Route::controller(RanperdaController::class)->group(function () {
            Route::post('/legislation/ranperda/trigger', 'trigger')->name('ranperda.trigger');
            Route::put('/legislation/ranperda/{ranperda}/approve', 'approve')->name('ranperda.approve');
            Route::put('/legislation/ranperda/{id}/restore', 'restore')->name('ranperda.restore');
            Route::delete('/legislation/ranperda/{id}/force-destroy', 'forceDestroy')->name('ranperda.force-destroy');
        });

        Route::resource('/legislation/ranperbup', RanperbupController::class);
        Route::controller(RanperbupController::class)->group(function () {
            Route::post('/legislation/ranperbup/trigger', 'trigger')->name('ranperbup.trigger');
            Route::put('/legislation/ranperbup/{ranperbup}/approve', 'approve')->name('ranperbup.approve');
            Route::put('/legislation/ranperbup/{id}/restore', 'restore')->name('ranperbup.restore');
            Route::delete('/legislation/ranperbup/{id}/force-destroy', 'forceDestroy')->name('ranperbup.force-destroy');
        });

        Route::resource('/legislation/ransk', RanskController::class);
        Route::controller(RanskController::class)->group(function () {
            Route::post('/legislation/ransk/trigger', 'trigger')->name('ransk.trigger');
            Route::put('/legislation/ransk/{ransk}/approve', 'approve')->name('ransk.approve');
            Route::put('/legislation/ransk/{id}/restore', 'restore')->name('ransk.restore');
            Route::delete('/legislation/ransk/{id}/force-destroy', 'forceDestroy')->name('ransk.force-destroy');
        });

        Route::resource('/legislation/document', DocumentController::class)->except([
            'index', 'create'
        ]);
        Route::controller(DocumentController::class)->group(function () {
            Route::post('/legislation/document/create', 'create')->name('document.create');
            Route::put('/legislation/document/{document}/ratify', 'ratify')->name('document.ratify');
        });

        Route::post('/legislation/comment', [CommentController::class, 'store'])
            ->name('comment.store');

        Route::get('/legislation/search', [LegislationController::class, 'search'])
            ->name('search');
    });

    Route::get('/setting', [SettingController::class, 'app'])
        ->name('setting.app');
    Route::put('/setting', [SettingController::class, 'update'])
        ->name('setting.update');

});