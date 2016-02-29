<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GoProp\Facades\AddressHelper;

class LocationController extends Controller
{
    public function indexArea(Request $request)
    {
        $qb = DB::table('rajaongkir_indonesia_subdistricts AS S')
            ->leftJoin('rajaongkir_indonesia_cities AS C', 'S.city_id', '=', 'C.city_id')
            ->leftJoin('rajaongkir_indonesia_provinces AS P', 'C.province_id', '=', 'P.province_id')
            ->orderBy('sort_order', 'ASC');

        if($request->has('search')){
            if($request->has('search.province')){
                $qb->where('C.province_id', '=', $request->input('search.province'));
            }

            if($request->has('search.city')){
                $qb->where('S.city_id', '=', $request->input('search.city'));
            }

            if($request->has('search.subdistrict')){
                $qb->where('S.subdistrict_name', 'LIKE', '%'.$request->input('search.subdistrict').'%');
            }
        }

        $areas = $qb->paginate(50)->appends(['search' => $request->get('search')]);

        $provinces = ['' => 'Select Province'] + AddressHelper::getProvinces(true);
        $cities = ['' => 'Select City'] + AddressHelper::getCities(empty($request->input('search.province'))?'all':$request->input('search.province'), true);

        return view('admin.location.area.index', [
            'areas' => $areas,
            'cities' => $cities,
            'provinces' => $provinces
        ]);
    }

    public function createArea()
    {
        $area = (object) array('subdistrict_name' => NULL, 'city_id' => null, 'sort_order' => 0);

        $cities = [];

        $provinces = AddressHelper::getProvinces(true);

        foreach($provinces as $idx=>$province){
            $cities[$province] = AddressHelper::getCities($idx, true, true);
        }

        $cities = ['' => 'Select City'] + $cities;

        return view('admin.location.area.create', [
            'cities' => $cities,
            'area' => $area
        ]);
    }

    public function storeArea(Request $request)
    {
        $rules = $this->getAreaRules();
        $this->validate($request, $rules);

        $qb = DB::table('rajaongkir_indonesia_subdistricts')->insert([
            'subdistrict_name' => $request->get('title'),
            'city_id' => $request->get('city'),
            'sort_order' => $request->get('sort_order')
        ]);

        return redirect($request->get('backUrl', route('admin.location.area.index')))->with('messages', ['Area has been created.']);
    }

    public function editArea($id)
    {
        $qb = DB::table('rajaongkir_indonesia_subdistricts AS S')
            ->leftJoin('rajaongkir_indonesia_cities AS C', 'S.city_id', '=', 'C.city_id')
            ->leftJoin('rajaongkir_indonesia_provinces AS P', 'C.province_id', '=', 'P.province_id')
            ->where('subdistrict_id', $id);
        $area = $qb->first();

        $cities = [];

        $provinces = AddressHelper::getProvinces(true);

        foreach($provinces as $idx=>$province){
            $cities[$province] = AddressHelper::getCities($idx, true, true);
        }

        $cities = ['' => 'Select City'] + $cities;

        return view('admin.location.area.edit', [
            'cities' => $cities,
            'area' => $area
        ]);
    }

    public function updateArea(Request $request, $id)
    {
        $rules = $this->getAreaRules();
        $this->validate($request, $rules);

        $qb = DB::table('rajaongkir_indonesia_subdistricts')->where('subdistrict_id', $id)->update([
            'subdistrict_name' => $request->get('title'),
            'city_id' => $request->get('city'),
            'sort_order' => $request->get('sort_order')
        ]);

        return redirect($request->get('backUrl', route('admin.location.area.index')))->with('messages', ['Area has been updated.']);
    }

    public function deleteArea(Request $request, $id)
    {
        $propertyCount = Property::where('subdistrict', $id)->count();

        if($propertyCount > 0){
            return redirect()->back()->withErrors(['Area can\'t be deleted because it is used by Property.']);
        }

        $qb = DB::table('rajaongkir_indonesia_subdistricts')->where('subdistrict_id', $id)->delete();

        return redirect()->back()->with('messages', ['Area has been deleted.']);
    }

    public function getAreaRules()
    {
        return [
            'title' => 'required',
            'city' => 'required|integer',
            'sort_order' => 'integer'
        ];
    }
}
