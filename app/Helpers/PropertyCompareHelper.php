<?php

namespace GoProp\Helpers;

use GoProp\Models\Property;
use Illuminate\Support\Facades\Session;

class PropertyCompareHelper
{
    public function getCurrentList()
    {
        $compareList = Session::get('properties_in_comparison', []);
        $return = [];

        foreach($compareList as $propertyId){
            $return[] = Property::findOrFail($propertyId);
        }

        $return = collect($return);

        return $return;
    }

    public function addToComparison($property)
    {
        if(!in_array($property->id, Session::get('properties_in_comparison', []))){
            Session::push('properties_in_comparison', $property->id);
        }
    }

    public function removeFromComparison($property)
    {
        $modified = array_diff(Session::pull('properties_in_comparison', []), [$property->id]);

        Session::put('properties_in_comparison', $modified);
    }

    public function isAddedToComparison($property)
    {
        return in_array($property->id, Session::get('properties_in_comparison', []));
    }
}