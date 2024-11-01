<?php

use App\Http\Middleware\AdminAuthCheck;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Auth\Middleware\Authenticate;


use App\Console\Commands\DatabaseBackup;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group([
                    __DIR__ . '/../routes/command.php',
                ]);
        },

    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            // \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            // Laravel\Passport\PassportServiceProvider::class,

        ]);

        $middleware->alias([
            'role'                          => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'                    => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission'            => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'auth.api'                      => \App\Http\Middleware\Authenticate::class,
            'cors'                          => \App\Http\Middleware\Cors::class,
            'throttle'                      => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'admin'                         => AdminAuthCheck::class,
        ]);
        //

        $middleware->api(prepend: [
            Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
