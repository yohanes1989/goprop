<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class ViewingSchedule extends Model
{
    public $timestamps = FALSE;
    public $dates = ['viewing_from', 'viewing_until'];
    protected $guarded = [];

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';

    //Relations
    public function user()
    {
        return $this->belongsTo('GoProp\Models\User');
    }

    public function property()
    {
        return $this->belongsTo('GoProp\Models\Property');
    }

    public function agent()
    {
        return $this->belongsTo('GoProp\Models\User', 'agent_id');
    }

    //Scopes
    public function scopeConfirmed($query)
    {
        $query->where('status', 'confirmed');
    }

    //Statics
    public static function getStatusLabel($option=null)
    {
        $array = [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }
}
