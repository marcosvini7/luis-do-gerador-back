<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LimitAcess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    { 
        if(env('APP_ENV')=='production') {
            $ipArray = ['127.0.0.1']; 

            if( in_array($request->ip(), $ipArray)){
                return $next($request);           
            } else {
                return response("Você não tem permissão para acessar esse recurso!", 503);
            }
        } else {
            return $next($request);
        }
       
    }
}
