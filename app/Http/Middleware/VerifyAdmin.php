<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $session = session('admin-session');
        if(!$session) return redirect(route('login'));
        return $next($request);
    }
}
