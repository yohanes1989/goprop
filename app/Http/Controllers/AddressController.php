<?php

namespace GoProp\Http\Controllers;

use GoProp\Facades\AddressHelper;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function get(Request $request, $type)
    {
        $lists = [];

        switch($type){
            case 'provinces':
                $lists = AddressHelper::getProvinces(true);
                break;
            case 'cities':
                $lists = AddressHelper::getCities($request->get('province_id', null), true);
                break;
            case 'subdistricts':
                $lists = AddressHelper::getSubdistricts($request->get('city_id', null), true);
                break;
        }

        if($request->has('default_label')){
            $defaultLabel = $request->input('default_label');
        }else{
            $defaultLabel = trans('forms.please_select');
        }

        $return = [$defaultLabel] + $lists;

        return response()->json($return);
    }
}