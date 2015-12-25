<?php

namespace GoProp\Http\Middleware;

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
                $routeAction = $request->route()->getAction();

                if(isset($routeAction['middleware']) && is_array($routeAction['middleware'])){
                    if(in_array('admin.auth', $routeAction['middleware'])){
                        return redirect()->guest(action('Admin\Auth\AuthController@getLogin'));
                    }
                }

                return redirect()->guest(action('Frontend\Auth\AuthController@getLogin'));
            }
        }

        return $next($request);
    }
}
