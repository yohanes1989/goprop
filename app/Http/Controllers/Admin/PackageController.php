<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\Package;

class PackageController extends Controller
{
    public function features($id, $all=TRUE)
    {
        $package = Package::findOrFail($id);

        $return = [];
        foreach($package->features as $feature){
            if(empty(round($feature->pivot->price))){
                if($all){
                    $return[$feature->id] = [
                        'name' => $feature->name,
                        'price' => 0,
                        'category' => $package->category->slug
                    ];
                }
            }else{
                $return[$feature->id] = [
                    'name' => $feature->name,
                    'price' => $feature->pivot->price,
                    'category' => $package->category->slug
                ];
            }
        }

        return response()->json($return);
    }
}
