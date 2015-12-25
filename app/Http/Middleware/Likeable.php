<?php

namespace GoProp\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Likeable
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
                return response(trans('property.like.please_login'), 401);
            } else {
                return redirect()->guest(action('Frontend\Auth\AuthController@getLogin'))->with('messages', [trans('property.like.please_login')]);
            }
        }

        return $next($request);
    }
}
