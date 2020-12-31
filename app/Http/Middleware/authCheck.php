<?php

namespace App\Http\Middleware;

use Closure;

class authCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->guard('user')->check()){
            return redirect('/');
        }
        return $next($request);
    }
}
