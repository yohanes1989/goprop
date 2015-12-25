<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const STATUS_CART = 'cart';
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public $dates = ['deleted_at'];
    public $skipPackage = FALSE;

    protected $guarded = [];

    //Relations
    public function user()
    {
        return $this->belongsTo('GoProp\Models\User');
    }

    public function property()
    {
        return $this->belongsTo('GoProp\Models\Property');
    }

    public function package()
    {
        return $this->belongsTo('GoProp\Models\Package');
    }

    public function items()
    {
        return $this->hasMany('GoProp\Models\OrderItem')->orderBy('sort_order', 'ASC');
    }

    public function payments()
    {
        return $this->hasMany('GoProp\Models\Payment');
    }

    //Methods
    public function calculate()
    {
        $this->total_quantity = 0;
        $this->total_amount = 0;
        foreach($this->items as $item){
            $this->total_quantity += $item->quantity;
            $this->total_amount += $item->quantity * $item->net_price;
        }
    }

    public function getAddons()
    {
        $return = [];

        foreach($this->items as $item){
            if($item->item_type == 'feature'){
                $return[] = $item->getItem();
            }
        }

        return $return;
    }

    public function generateOrderNumber()
    {
        $lastOrder = self::withTrashed()
            ->where('status', '<>', self::STATUS_CART)
            ->orderBy('order_number', 'DESC')
            ->first();

        if(!$lastOrder){
            $lastOrderNumber = 0;
        }else{
            $lastOrderNumber = intval($lastOrder->order_number);
        }

        $this->order_number = str_pad($lastOrderNumber+1, 6, '0', STR_PAD_LEFT);
    }

    //Statics
    public static function getStatusLabel($option=null)
    {
        $array = [
            self::STATUS_CART => trans('order.status.'.self::STATUS_CART),
            self::STATUS_PENDING => trans('order.status.'.self::STATUS_PENDING),
            self::STATUS_CONFIRMED => trans('order.status.'.self::STATUS_CONFIRMED),
            self::STATUS_COMPLETED => trans('order.status.'.self::STATUS_COMPLETED),
            self::STATUS_CANCELLED => trans('order.status.'.self::STATUS_CANCELLED),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }
}
