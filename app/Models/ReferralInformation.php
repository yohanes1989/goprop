<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralInformation extends Model
{
    const STATUS_MAYBE = 'Maybe';
    const STATUS_YES = 'Yes';
    const STATUS_NO = 'No';

    protected $fillable = ['name', 'contact_number', 'other_contact_number', 'email', 'property_type_id', 'address', 'province', 'city', 'subdistrict', 'postal_code', 'status', 'followed_up'];
    protected $casts = [
        'followed_up' => 'boolean'
    ];

    //Relations
    public function user()
    {
        return $this->belongsTo('GoProp\Models\User');
    }

    public function type()
    {
        return $this->belongsTo('GoProp\Models\PropertyType', 'property_type_id');
    }

    //Statics
    public static function getStatusOptions($option=null)
    {
        $array = [
            self::STATUS_MAYBE => 'Maybe',
            self::STATUS_YES => 'Yes',
            self::STATUS_NO => 'No',
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }
}
