<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthenticationMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__ . '/../routes/web.php', commands: __DIR__ . '/../routes/console.php', health: '/up')
    ->withMiddleware(function (Middleware $middleware): void {
        $authMiddleware = AuthenticationMiddleware::class;
        $adminMiddleware = AdminMiddleware::class;
        $customerMiddleware = CustomerMiddleware::class;
        $roleMiddleware = RoleMiddleware::class;
        $permissionMiddleware = PermissionMiddleware::class;



        // Authentication
        $middleware->appendToGroup('authenticationMiddlewares', [
            $authMiddleware,
        ]);

        // Admin
        $middleware->appendToGroup('adminMiddlewares', [
            $adminMiddleware,
            $permissionMiddleware,
            $roleMiddleware,
        ]);

        // customers
        $middleware->appendToGroup('customerMiddlewares', [
            $customerMiddleware,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(fn(Request $request) => $request->is('api/*') || $request->expectsJson());
    })
    ->create();
