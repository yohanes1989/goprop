<?php

namespace GoProp\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kodeine\Acl\Traits\HasRole;

class User extends Model implements AuthenticatableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, HasRole;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED = 'blocked';

    protected $fillable = ['email', 'username', 'password', 'status'];

    protected $hidden = ['password', 'remember_token'];

    //Methods
    public function getIncompleteProperties()
    {
        return $this->properties()->incomplete()->get();
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
            $conversation = $property->messages()->whereNull('parent_id')->first();

            return $conversation;
        }

        return FALSE;
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
