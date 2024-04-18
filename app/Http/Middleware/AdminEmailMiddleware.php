<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminEmailMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->email === 'admin@plm.edu.ph') {
            return $next($request);
        }

        return redirect('/studentOfficer/login');
    }
}
