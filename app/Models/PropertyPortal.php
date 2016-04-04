<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyPortal extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    //Relations
    public function properties()
    {
        return $this->belongsToMany('GoProp\Models\Property', 'property_property_portal')->withTimestamps()->withPivot(['user_id']);
    }

    //Statics
    public static function getAllPortals()
    {
        return self::orderBy('sort_order', 'ASC')->get();
    }
}
