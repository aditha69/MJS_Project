<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DokterAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('dokter_id')) {
            return redirect()->route('dokter.login');
        }

        return $next($request);
    }
}
