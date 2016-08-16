<?php

namespace GoProp\Http\Middleware\Admin;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AppropriateBackend
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
        if ($this->auth->check()) {
            $routeAction = $request->route()->getAction();

            $isBackend = in_array('admin.auth', $routeAction['middleware']);

            //If Referral Agent in wrong backend url
            if(!$this->auth->user()->hasBackendAccess){
                return redirect()->route('frontend.page.home');
            }

            if($this->auth->user()->backendAccess != 'admin' && $isBackend){
                return redirect()->route('portal.dashboard');
            }elseif($this->auth->user()->backendAccess == 'admin' && !$isBackend){
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
