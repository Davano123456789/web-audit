<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()) {
            abort(403, 'Akses ditolak. Silakan login terlebih dahulu.');
        }

        // Admin has access to all pages (bypasses specific role requirements)
        if ($request->user()->role === 'admin') {
            return $next($request);
        }

        if ($request->user()->role !== $role) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
