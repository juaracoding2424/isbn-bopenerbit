<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api')
                ->name('api.')
                ->group(base_path('routes/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        /*$middleware->redirectGuestsTo(function (Request $request) {
            //if ($request->is('api/*')) {
            return route('login');
            //} else {
            //    return route('...');
            //}
        });
        /*$middleware->alias([
            //'penerbit' => \App\Http\Middleware\PenerbitMiddleware::class,
            //'guest'    => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);*/
        $middleware->validateCsrfTokens(except: [
            'page/redirect' // <-- exclude this route
        ]);
        $middleware->append(\App\Http\Middleware\RedirectIfAuthenticated::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
