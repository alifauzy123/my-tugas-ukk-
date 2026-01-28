<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role === 'admin') {
            if (!Auth::guard('web')->check() || Auth::guard('web')->user()->role !== 'admin') {
                return redirect()->route('login')->with('error', 'Akses admin ditolak.');
            }
        }

        if ($role === 'owner') {
            if (!Auth::guard('web')->check() || Auth::guard('web')->user()->role !== 'owner') {
                return redirect()->route('login')->with('error', 'Akses owner ditolak.');
            }
        }

        if ($role === 'kasir') {
            if (!Auth::guard('kasir')->check()) {
                return redirect()->route('login')->with('error', 'Akses kasir ditolak.');
            }
        }

        return $next($request);
    }
}
