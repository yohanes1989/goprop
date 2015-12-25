<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    public $timestamps = FALSE;

    protected $guarded = [];

    //Relations
    public function packages()
    {
        return $this->hasMany('GoProp\Models\Package')->orderBy('sort_order', 'ASC');
    }

    //Methods
    public function getPackageWithMostFeatures()
    {
        $mostPackage = $this->packages->first();

        foreach($this->packages as $package){
            if($package->features->count() > $mostPackage->features->count()){
                $mostPackage = $package;
            }
        }

        return $mostPackage;
    }
}
