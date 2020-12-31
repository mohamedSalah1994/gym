<?php

namespace App\Http\Middleware;

use Closure;
use App\permissions;
class adminCheck
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
         if(!auth()->guard('admin')->check()){
            return redirect(route('admin.login.show'));
        }
        $route = \Request::route()->getName();
        $checkPermission = permissions::where('route',$route)->first();
        if($checkPermission){
            $checkAllow = auth()->guard('admin')->user()->checkPermission($checkPermission->id);
            if(!$checkAllow && auth()->guard('admin')->user()->role->role != 1){
                return abort(401);
            }
        }
        return $next($request);
    }
}
