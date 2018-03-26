<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    

    public function handle($request, Closure $next ,$permission)
    {   
        // dd($request->user()->permissions); 
        if (! $request->user()->can($permission)&& ! $request->user()->hasRole('admin')) {
           abort(403);
        }
        

        return $next($request);
    }
}
