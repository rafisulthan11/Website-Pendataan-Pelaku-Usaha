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
        // Cek jika user sudah login DAN rolenya bukan 'admin'
        if (Auth::check() && Auth::user()->role?->nama_role !== 'admin') {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        // Jika user adalah admin, izinkan request untuk melanjutkan
        return $next($request);
    }
}