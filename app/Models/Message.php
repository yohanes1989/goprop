<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const TYPE_OWNER_MESSAGE = 'owner_message';
    const TYPE_USER_MESSAGE = 'user_message';

    protected $guarded = ['parent_id'];

    public $dates = ['read_at'];

    //Relations
    public function sender()
    {
        return $this->belongsTo('GoProp\Models\User', 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo('GoProp\Models\User', 'recipient_id');
    }

    public function replies()
    {
        return $this
            ->hasMany('GoProp\Models\Message', 'parent_id');
        /*
            ->select($this->getTable().'.*')
            ->selectRaw('CONCAT(P.first_name, " ", P.last_name) AS sender_name')
            ->leftJoin('profiles AS P', 'P.user_id', '=', 'sender_id');
        */
    }

    public function parentMessage()
    {
        return $this->belongsTo('GoProp\Models\Message', 'parent_id');
    }

    public function referenced()
    {
        return $this->morphTo();
    }

    //Accessor
    public function getLastReplyAttribute()
    {
        return $this->replies?$this->replies->last():NULL;
    }
}
