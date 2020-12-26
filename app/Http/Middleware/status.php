<?php

namespace App\Http\Middleware;

use Closure;

class status
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
        if(!auth()->user()->status == 1) {

            return  redirect('activate');
        }
        return $next($request);
    }
}
