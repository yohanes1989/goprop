<?php

namespace GoProp\Http\Middleware;

use Closure;
use GoProp\Models\Property;

class PropertyCartOrder
{
    /**
     * Create a new filter instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $order = $property->getCartOrder();

        if(empty($order)){
            return redirect()->route('frontend.property.create');
        }

        return $next($request);
    }
}
