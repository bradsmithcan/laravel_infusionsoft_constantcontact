<?php namespace App\Http\Middleware;

use Closure;

class NotChild {

    public function handle($request, Closure $next)
    {

        if ( \Auth::check() && \Auth::user()->isNotChild() &&  \Auth::user()->isActive() )
        {
            return $next($request);
        }

        return redirect('home');

    }

}