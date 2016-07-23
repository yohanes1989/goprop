<?php

namespace GoProp\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kodeine\Acl\Traits\HasRole;

class User extends Model implements AuthenticatableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, HasRole;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED = 'blocked';

    protected $fillable = ['email', 'username', 'facebook_id', 'password', 'status'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'manage_property' => 'boolean'
    ];

    //Methods
    public function getIncompleteProperties()
    {
        return $this->properties()->incomplete()->get();
    }

    public function getName()
    {
        $fullName = $this->profile?$this->profile->singleName:'';

        if(empty($fullName)){
            $fullName = $this->email;
        }

        return $fullName;
    }

    //Accessors
    public function getHasBackendAccessAttribute()
    {
        return $this->is('administrator|agent');
    }

    public function getBackendAccessAttribute()
    {
        if($this->is('agent')){
            return !$this->manage_property?'portal':'admin';
        }

        return 'admin';
    }

    //Relations
    public function profile()
    {
        return $this->hasOne('GoProp\Models\Profile');
    }

    public function subscriptions()
    {
        return $this->belongsToMany('GoProp\Models\Subscription');
    }

    public function handledProperty()
    {
        return $this->hasMany('GoProp\Models\Property', 'agent_id');
    }

    public function properties()
    {
        return $this->hasMany('GoProp\Models\Property');
    }

    public function viewingSchedules()
    {
        return $this->hasMany('GoProp\Models\ViewingSchedule');
    }

    public function likedProperties()
    {
        return $this->belongsToMany('GoProp\Models\Property', 'liked_properties')
            ->withTimestamps()
            ->orderBy('created_at', 'DESC');
    }

    public function likesAProperty($property)
    {
        return $this->likedProperties->contains($property->id);
    }

    public function likeProperty($property)
    {
        if(!$this->likesAProperty($property)){
            $this->likedProperties()->attach($property->id);
        }
    }

    public function unlikeProperty($property)
    {
        $this->likedProperties()->detach($property->id);
    }

    public function getPropertyConversation($property)
    {
        if($property){
            $conversation = $property->messages()->where('sender_id', $this->id)->whereNull('parent_id')->first();

            return $conversation;
        }

        return FALSE;
    }

    public function createPropertyConversation($property, $agent = NULL)
    {
        if(!$property->relationLoaded('agentList')){
            $property->load('agentList');
        }

        if(!$agent){
            if($property->agentList){
                $agent = $property->agentList;
            }
        }

        //Create new conversation
        $conversation = new Message();
        if($property->user_id == $this->id){
            $conversation->type = Message::TYPE_OWNER_MESSAGE;
        }else{
            $conversation->type = Message::TYPE_USER_MESSAGE;
        }
        $conversation->sender()->associate($this);
        $conversation->referenced()->associate($property);
        if($agent){
            $conversation->recipient()->associate($agent);
        }
        $conversation->save();

        return $conversation;
    }

    //Statics
    public static function getStatusLabel($option=null)
    {
        $array = [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_BLOCKED => 'Blocked',
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    //Events
    public static function boot()
    {
        parent::boot();

        static::deleting(function($user){
            $user->load('profile');

            if(!empty($user->profile)){
                $user->profile->removeProfilePicture();
            }
        });
    }
}
