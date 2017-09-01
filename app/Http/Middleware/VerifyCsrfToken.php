<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [];

    public function handle($request,Closure $next )
    {   
        if($request->getRealMethod()=='GET'){
            unset($request->_token);
        }
        else{
            $test = $request->input();
            unset($test['_token']);
            $request->request->replace($test);
        }
        return $next($request);

    }
    
    
}
