<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class ViewingSchedule extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;

    public $timestamps = FALSE;
    public $dates = ['viewing_from', 'viewing_until'];
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

    public function agent()
    {
        return $this->belongsTo('GoProp\Models\User', 'agent_id');
    }
}
