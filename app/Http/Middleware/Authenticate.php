<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {

                return redirect()->guest('/');
            }
        }

        if ( \Auth::user()->archive == 1 ) {
            $email = \Auth::user()->email;
            \Auth::logout();
            return view('auth.suspended_user', compact('email'));
        }

        if (!\Auth::user()->isActive() ) {
            $email = \Auth::user()->email;
            $date = \Auth::user()->created_at->format('Y-m-d');
            \Auth::logout();
            return view('auth.guest_activate')
                ->with( 'email', $email )
                ->with( 'date', $date );
        }
        return $next($request);
    }
}
