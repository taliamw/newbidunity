<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckLocked
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $session = DB::table('sessions')->where('id', session()->getId())->first();

            if ($session && $session->is_locked) {
                return redirect()->route('lock-screen');
            }
        }

        return $next($request);
    }
}