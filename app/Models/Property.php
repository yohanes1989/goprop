<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED = 'blocked';
    const STATUS_DRAFT = 'draft';

    const RENT_PRICE_TYPE_MONTHLY = 'monthly';
    const RENT_PRICE_TYPE_YEARLY = 'yearly';

    const VIEWING_SCHEDULE_OPTION_WEEKDAYS = 'weekdays';
    const VIEWING_SCHEDULE_OPTION_WEEKEND = 'weekend';

    const PARKING_GARAGE = 'garage';
    const PARKING_PRIVATE = 'private';
    const PARKING_STREET = 'street';

    const FURNISHING_FURNISHED = 'furnished';
    const FURNISHING_PART_FURNISHED = 'part_furnished';
    const FURNISHING_UNFURNISHED = 'unfurnished';

    const CERTIFICATE_STRATA_TITLE = 'strata_title';
    const CERTIFICATE_HGB = 'hgb';
    const CERTIFICATE_HM = 'hm';

    public static $residentialSlugs = ['house', 'apartment', 'townhouse'];

    protected $dates = ['deleted_at', 'checkout_at'];
    protected $fillable = ['property_name', 'province', 'city', 'subdistrict', 'address', 'postal_code',
        'property_type_id', 'parking', 'garage_size', 'rooms', 'bathrooms', 'for_sell', 'sell_price',
        'for_rent', 'rent_price', 'rent_price_type', 'land_size', 'building_size', 'floors', 'certificate', 'description',
        'virtual_tour_url', 'latitude', 'longitude', 'status', 'checkout_at'];

    //Relations
    public function user()
    {
        return $this->belongsTo('GoProp\Models\User');
    }

    public function type()
    {
        return $this->belongsTo('GoProp\Models\PropertyType', 'property_type_id');
    }

    public function photos()
    {
        return $this->hasMany('GoProp\Models\PropertyAttachment')->where('type', 'photo');
    }

    public function floorplans()
    {
        return $this->hasMany('GoProp\Models\PropertyAttachment')->where('type', 'floorplan');
    }

    public function attachments()
    {
        return $this->hasMany('GoProp\Models\PropertyAttachment');
    }

    public function orders()
    {
        return $this->hasMany('GoProp\Models\Order');
    }

    public function order()
    {
        return $this->hasOne('GoProp\Models\Order');
    }

    public function packages()
    {
        return $this->belongsToMany('GoProp\Models\Package');
    }

    public function likedBy()
    {
        return $this->belongsToMany('GoProp\Models\User', 'liked_properties');
    }

    public function messages()
    {
        return $this->morphMany('GoProp\Models\Message', 'referenced')->orderBy('created_at', 'ASC');
    }

    //Scopes
    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    //Methods
    public function getPhotoThumbnail()
    {
        if($this->photos->count() > 0){
            return $this->photos->first()->filename;
        }

        return 'property-default.jpg';
    }

    public function isLikedBy($user)
    {
        $foundUser = NULL;

        if($user){
            $foundUser = $this->likedBy()->where('user_id', $user->id)->first();
        }

        return !empty($foundUser);
    }

    public function getViewFor($for=NULL)
    {
        if(!is_null($for)){
            if(!empty($this->{'for_'.$for})){
                return $for;
            }
        }

        if($this->for_sell){
            $for = 'sell';
        }else{
            $for = 'rent';
        }

        return $for;
    }

    public function getPrice($type)
    {
        return $this->{$type.'_price'};
    }

    public function isResidential()
    {
        return in_array($this->type->slug, self::$residentialSlugs);
    }

    public function processViewingSchedule($attributes)
    {
        if(isset($attributes['rent_viewing_schedule']) && is_array($attributes['rent_viewing_schedule'])){
            $this->rent_viewing_schedule = implode('|', $attributes['rent_viewing_schedule']);
        }

        if(isset($attributes['sell_viewing_schedule']) && is_array($attributes['sell_viewing_schedule'])){
            $this->sell_viewing_schedule = implode('|', $attributes['sell_viewing_schedule']);
        }
    }

    public function savePhoto($photo, $type, $sort_order = 0)
    {
        $fileName = $this->id.'_'.filter_var($photo->getClientOriginalName(), FILTER_SANITIZE_STRING);

        $propertyAttachment = new PropertyAttachment();

        if($type == 'photo'){
            $uploadPath = $propertyAttachment::$photosUploadPath;
        }elseif($type == 'floorplan'){
            $uploadPath = $propertyAttachment::$floorplanUploadPath;
        }

        Storage::disk('local')->put($uploadPath.'/'.$fileName, File::get($photo));

        $propertyAttachment->fill([
            'title' => filter_var($photo->getClientOriginalName(), FILTER_SANITIZE_STRING),
            'filename' => $fileName,
            'sort_order' => $sort_order,
            'type' => $type
        ]);
        $propertyAttachment->property()->associate($this);
        $propertyAttachment->save();

        return $propertyAttachment;
    }

    public function getCartOrder()
    {
        return $this->orders()->where('status', Order::STATUS_CART)->first();
    }

    //Scopes
    public function scopeIncomplete($query)
    {
        $query->where('status', self::STATUS_DRAFT);
    }

    //Statics
    public static function getForLabel($option=null)
    {
        $array = [
            'sell' => trans('property.for.sell'),
            'rent' => trans('property.for.rent'),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getStatusLabel($option=null)
    {
        $array = [
            self::STATUS_ACTIVE => trans('property.status.'.self::STATUS_ACTIVE),
            self::STATUS_INACTIVE => trans('property.status.'.self::STATUS_INACTIVE),
            self::STATUS_BLOCKED => trans('property.status.'.self::STATUS_BLOCKED),
            self::STATUS_DRAFT => trans('property.status.'.self::STATUS_DRAFT),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getRentTypeLabel($option=null)
    {
        $array = [
            self::RENT_PRICE_TYPE_YEARLY => trans('property.rent_price_type.'.self::RENT_PRICE_TYPE_YEARLY),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getViewingScheduleOptionLabel($option=null)
    {
        $array = [
            self::VIEWING_SCHEDULE_OPTION_WEEKDAYS => trans('property.viewing_schedule_option.'.self::VIEWING_SCHEDULE_OPTION_WEEKDAYS),
            self::VIEWING_SCHEDULE_OPTION_WEEKEND => trans('property.viewing_schedule_option.'.self::VIEWING_SCHEDULE_OPTION_WEEKEND),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getParkingOptionLabel($option=null)
    {
        $array = [
            self::PARKING_GARAGE => trans('property.parking.'.self::PARKING_GARAGE),
            self::PARKING_PRIVATE => trans('property.parking.'.self::PARKING_PRIVATE),
            self::PARKING_STREET => trans('property.parking.'.self::PARKING_STREET),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getFurnishingLabel($option=null)
    {
        $array = [
            self::FURNISHING_FURNISHED => trans('property.furnishing.'.self::FURNISHING_FURNISHED),
            self::FURNISHING_PART_FURNISHED => trans('property.furnishing.'.self::FURNISHING_PART_FURNISHED),
            self::FURNISHING_UNFURNISHED => trans('property.furnishing.'.self::FURNISHING_UNFURNISHED),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getCertificateLabel($option=null)
    {
        $array = [
            self::CERTIFICATE_STRATA_TITLE => trans('property.certificate.'.self::CERTIFICATE_STRATA_TITLE),
            self::CERTIFICATE_HGB => trans('property.certificate.'.self::CERTIFICATE_HGB),
            self::CERTIFICATE_HM => trans('property.certificate.'.self::CERTIFICATE_HM),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getBedroomsLabel($option=null)
    {
        $array = [];
        for($i = 1; $i <= 10; $i += 1){
            $array[$i] = trans_choice('forms.fields.property.room_count', $i);
        }

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getBathroomsLabel($option=null)
    {
        $array = [];
        for($i = 1; $i <= 5; $i += 1){
            $array[$i] = trans_choice('forms.fields.property.bathroom_count', $i);
        }

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getFloorsLabel($option=null)
    {
        $array = [
            '1' => '1',
            '1.5' => '1.5',
            '2' => '2',
            '2.5' => '2.5',
            '3' => '3',
            '3.5' => '3.5',
            '4' => '4',
            '4.5' => '4.5',
            '5' => '5'
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getViewingTimeLabel($option=null)
    {
        $array = [
            '09_00' => '09:00',
            '10_00' => '10:00',
            '11_00' => '11:00',
            '12_00' => '12:00',
            '13_00' => '13:00',
            '14_00' => '14:00',
            '15_00' => '15:00',
            '16_00' => '16:00',
            '17_00' => '17:00',
            '18_00' => '18:00',
            '19_00' => '19:00',
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }
}
