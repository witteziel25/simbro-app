<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }

        if (!empty($roles) && !in_array(session('role'), $roles)) {
            if (session('role') == 1) {
                return redirect()->route('admin.home')->withErrors('Akses ditolak.');
            } else {
                return redirect()->route('customer.home')->withErrors('Akses ditolak.');
            }
        }

        return $next($request);
    }
}
