<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class PackageFeature extends Model
{
    public $timestamps = FALSE;

    protected $guarded = [];

    //Relations
    public function packages()
    {
        return $this->belongsToMany('GoProp\Models\Package', 'package_package_feature')->orderBy('sort_order', 'ASC');
    }

    //Methods
    public function isPackageFeature(Package $package)
    {
        return $this->packages->contains('id', $package->id);
    }
}
