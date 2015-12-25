<?php

namespace GoProp\Http\Middleware;

use Closure;
use GoProp\Models\Property;
use Illuminate\Contracts\Auth\Guard;

class PropertyOwner
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
        $property = Property::findOrFail($propertyId);

        if($property->user->id != $this->auth->user()->id){
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('frontend.property.create');
            }
        }

        return $next($request);
    }
}
