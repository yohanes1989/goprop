<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;

    public $timestamps = FALSE;

    protected $guarded = [];

    //Methods
    public function getItem()
    {
        if($this->item_type == 'feature'){
            $item = PackageFeature::findOrFail($this->item);
        }

        return $item;
    }

    //Relations
    public function order()
    {
        return $this->belongsTo('GoProp\Models\Order');
    }
}
