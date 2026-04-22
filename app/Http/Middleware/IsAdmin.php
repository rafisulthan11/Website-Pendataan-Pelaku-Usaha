<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user sudah login DAN rolenya bukan admin/super admin
        if (Auth::check() && !Auth::user()->isAdminOrSuperAdmin()) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        // Jika user adalah admin atau super admin, izinkan request untuk melanjutkan
        return $next($request);
    }
}