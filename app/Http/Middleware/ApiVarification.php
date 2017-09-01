<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class ApiVarification
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
        
        if (! $request->user()->can($permission)&& ! $request->user()->hasRole('admin')) {
           abort(403);
        }
        

        return $next($request);
    }
}
