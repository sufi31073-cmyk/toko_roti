<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminWebMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // If not logged in, redirect to admin login page
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan masuk terlebih dahulu untuk mengakses panel admin.');
        }

        // If logged in but not an admin, logout and redirect
        if (!Auth::user()->is_admin) {
            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('admin.login')
                ->with('error', 'Akses ditolak. Halaman ini khusus untuk admin Dea Bakery.');
        }

        return $next($request);
    }
}
