<?php

namespace GoProp\Http\Middleware\Admin;

use Closure;
use GoProp\Models\Property;
use Illuminate\Contracts\Auth\Guard;

class CanEdit
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
        $propertyId = $request->route('id');
        $property = Property::withTrashed()->findOrFail($propertyId);

        if($this->auth->user()->is('agent') && $property->user_id != $this->auth->user()->id){
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->back()->withErrors(['You are not authorized to do this action']);
            }
        }

        return $next($request);
    }
}
