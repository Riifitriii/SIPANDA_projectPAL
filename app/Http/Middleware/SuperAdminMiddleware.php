<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     * Memastikan hanya user dengan role 'super_admin' yang diizinkan mengakses request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak. Fitur ini hanya dapat diakses oleh Super Admin.');
        }

        return $next($request);
    }
}
