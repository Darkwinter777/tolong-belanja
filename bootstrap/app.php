<?php

use App\Http\Middleware\SetPortalSessionCookie;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust reverse proxies (Tailscale Serve, and any future load balancer)
        // so Laravel generates https:// URLs when TLS is terminated upstream.
        $middleware->trustProxies(at: '*');

        $middleware->prependToGroup('web', SetPortalSessionCookie::class);

        $middleware->redirectGuestsTo(function ($request) {
            return $request->is('portal*')
                ? route('portal.login')
                : route('filament.admin.auth.login');
        });

        $middleware->redirectUsersTo(fn () => route('portal.home'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
