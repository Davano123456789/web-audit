<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Bind public path dynamically if public_html directory is detected (cPanel hosting compatibility)
$publicHtmlPath = dirname(__DIR__) . '/../public_html';
if (file_exists($publicHtmlPath)) {
    $app->usePublicPath(realpath($publicHtmlPath));
}

return $app;
