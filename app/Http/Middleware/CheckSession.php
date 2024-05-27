<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (session()->has('paused')) {
                session()->forget('paused');
            }
        } else {
            session(['paused' => true]);
        }

        return $next($request);
    }
}
