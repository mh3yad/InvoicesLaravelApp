<?php

namespace App\Http\Middleware;

use Closure;

class setLang
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
//        dd($request->getLocale());
        \App::setLocale($request->lang);
        return $next($request);
    }
}
