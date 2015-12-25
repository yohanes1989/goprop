<?php

namespace GoProp\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AddressHelper
{
    public $provinceTable = 'rajaongkir_indonesia_provinces';
    public $cityTable = 'rajaongkir_indonesia_cities';
    public $subdistrictTable = 'rajaongkir_indonesia_subdistricts';

    private $_provinces;
    private $_cities;
    private $_subdistricts;

    //Methods
    public function getProvinces($selectOption = FALSE)
    {
        if(!isset($this->_provinces)){
            $qb = DB::table($this->provinceTable);
            $this->_provinces = new Collection($qb->get());
        }

        if($selectOption){
            return $this->_provinces->lists('province_name', 'province_id')->all();
        }

        return $this->_provinces;
    }

    public function getCities($province_id = NULL, $selectOption = FALSE)
    {
        if(empty($province_id)){
            return [];
        }

        if(!isset($this->_cities)){
            $qb = DB::table($this->cityTable)->selectRaw('*, CONCAT(type, \' \', city_name) AS city_long_name');

            if(!is_null($province_id)){
                $qb->where('province_id', $province_id);
            }

            $this->_cities = new Collection($qb->get());
        }

        if($selectOption){
            return $this->_cities->lists('city_long_name', 'city_id')->all();
        }

        return $this->_cities;
    }

    public function getSubdistricts($city_id = NULL, $selectOption = FALSE)
    {
        if(empty($city_id)){
            return [];
        }

        if(!isset($this->_subdistricts)){
            $qb = DB::table($this->subdistrictTable);

            if(!is_null($city_id)){
                $qb->where('city_id', $city_id);
            }

            $this->_subdistricts = new Collection($qb->get());
        }

        if($selectOption){
            return $this->_subdistricts->lists('subdistrict_name', 'subdistrict_id')->all();
        }

        return $this->_subdistricts;
    }

    public function getAddressLabel($id, $type)
    {
        switch($type){
            case 'province':
                $item = DB::table($this->provinceTable)->where('province_id', $id)->first();
                $name = $item->province_name;
                break;
            case 'city':
                $item = DB::table($this->cityTable)->where('city_id', $id)->first();
                $name = $item->type.' '.$item->city_name;
                break;
            case 'subdistrict':
                $item = DB::table($this->subdistrictTable)->where('subdistrict_id', $id)->first();
                $name = $item->subdistrict_name;
                break;
        }

        return $name;
    }

    public function addAddressQueryScope(&$qb)
    {
        $qb->select($qb->getQuery()->from.'.*');
        $qb->addSelect('PROVINCES.province_name')->leftJoin($this->provinceTable.' AS PROVINCES', 'PROVINCES.province_id', '=', 'province');
        $qb->addSelect(DB::raw('CONCAT(CITIES.type, " ", CITIES.city_name) AS city_name'))->leftJoin($this->cityTable.' AS CITIES', 'CITIES.city_id', '=', 'city');
        $qb->addSelect('SUBDISTRICTS.subdistrict_name')->leftJoin($this->subdistrictTable.' AS SUBDISTRICTS', 'SUBDISTRICTS.subdistrict_id', '=', 'subdistrict');
    }
}