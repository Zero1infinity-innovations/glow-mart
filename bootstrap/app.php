<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then:function () {
            Route::middleware('web')->namespace("App\Http\Controllers\Frontend")->name('frontend.')->group(base_path('routes/web.php'));
            Route::middleware(['web'])->namespace('App\Http\Controllers\Admin')->name('admin.')->prefix('admin')->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        RedirectIfAuthenticated::redirectUsing(fn ()=> route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
