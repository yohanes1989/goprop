<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED = 'blocked';
    const STATUS_REVIEW = 'review';
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

    const ORIENTATION_NORTH = 'north';
    const ORIENTATION_NORTH_EAST = 'north_east';
    const ORIENTATION_EAST = 'east';
    const ORIENTATION_SOUTH_EAST = 'south_east';
    const ORIENTATION_SOUTH = 'south';
    const ORIENTATION_SOUTH_WEST = 'south_west';
    const ORIENTATION_WEST = 'west';
    const ORIENTATION_NORTH_WEST = 'north_west';

    const CERTIFICATE_STRATA_TITLE = 'strata_title';
    const CERTIFICATE_HGB = 'hgb';
    const CERTIFICATE_PPJB = 'ppjb';
    const CERTIFICATE_HPL = 'hpl';
    const CERTIFICATE_HM = 'hm';

    public static $residentialSlugs = ['house', 'apartment', 'townhouse'];

    public static $availableElectricity = [450, 900, 1300, 2200, 3500, 4400, 5500, 6600, 7600, 7700, 8000, 9000, 10000, 10600, 11000, 12700, 13200, 13300, 13900, 16500, 17600, 19000, 22000, 23000, 24000, 30500, 38100, 41500, 47500, 53000, 61000, 66000, 76000, 82500, 85000, 95000];

    protected $dates = ['deleted_at', 'checkout_at'];
    protected $fillable = ['property_name', 'listing_code', 'province', 'city', 'subdistrict', 'address', 'postal_code',
        'property_type_id', 'parking', 'garage_size', 'carport_size', 'rooms', 'bathrooms', 'maid_rooms', 'maid_bathrooms', 'for_sell', 'sell_price',
        'for_rent', 'rent_price', 'rent_price_type', 'land_size', 'land_dimension', 'building_size', 'building_dimension', 'floors', 'orientation', 'phone_lines', 'electricity', 'certificate', 'description',
        'virtual_tour_url', 'latitude', 'longitude', 'status', 'checkout_at', 'furnishing', 'short_note', 'personal_note'];

    //Relations
    public function user()
    {
        return $this->belongsTo('GoProp\Models\User');
    }

    public function agentList()
    {
        return $this->belongsTo('GoProp\Models\User', 'agent_list_id');
    }

    public function agentSell()
    {
        return $this->belongsTo('GoProp\Models\User', 'agent_sell_id');
    }

    public function referralList()
    {
        return $this->belongsTo('GoProp\Models\User', 'referral_list_id');
    }

    public function referralSell()
    {
        return $this->belongsTo('GoProp\Models\User', 'referral_sell_id');
    }

    public function type()
    {
        return $this->belongsTo('GoProp\Models\PropertyType', 'property_type_id');
    }

    public function photos()
    {
        return $this->hasMany('GoProp\Models\PropertyAttachment')->where('type', 'photo')->orderBy('sort_order', 'ASC');
    }

    public function floorplans()
    {
        return $this->hasMany('GoProp\Models\PropertyAttachment')->where('type', 'floorplan')->orderBy('sort_order', 'ASC');
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
        return $this->belongsToMany('GoProp\Models\Package')->withPivot(['addons']);
    }

    public function likedBy()
    {
        return $this->belongsToMany('GoProp\Models\User', 'liked_properties');
    }

    public function messages()
    {
        return $this->morphMany('GoProp\Models\Message', 'referenced')->orderBy('created_at', 'ASC');
    }

    public function conversations()
    {
        return $this->messages()->whereNull('parent_id');
    }

    public function viewingSchedules()
    {
        return $this->hasMany('GoProp\Models\ViewingSchedule');
    }

    public function generateListingCode()
    {
        if(empty($this->checkout_at) || !empty($this->listing_code)){
            abort(403, 'Can\'t generate listing code action.');
        }

        $getLastProperty = Property::withTrashed()
            ->hasCheckout()
            ->whereNotNull('listing_code')
            ->orderBy(DB::raw('CAST(SUBSTR(listing_code, 6) as UNSIGNED)'), 'DESC')
            ->whereRaw("DATE_FORMAT(checkout_at, '%m-%Y') = ?", [$this->checkout_at->format('m-Y')])
            ->first();

        if($getLastProperty){
            $lastListingNumber = intval(substr($getLastProperty->listing_code, 6));
        }else{
            $lastListingNumber = 0;
        }

        $listingNumber = $lastListingNumber + 1;

        $currentDateCode = $this->checkout_at->format('ym');

        $this->listing_code = 'GO'.$currentDateCode.str_pad($listingNumber, 2, '0', STR_PAD_LEFT);
    }

    //Accessors
    public function getLandDimensionAttribute()
    {
        $return = [
            'length' => null,
            'width' => null,
        ];

        if(isset($this->attributes['land_dimension'])){
            $explodes = explode('x', $this->attributes['land_dimension']);

            $return = [
                'length' => isset($explodes[0])?$explodes[0]:0,
                'width' => isset($explodes[1])?$explodes[1]:0,
            ];
        }

        return $return;
    }

    public function getLandDimensionWithUnitAttribute()
    {
        $dimensions = $this->land_dimension?$this->land_dimension:[];
        $return = '';

        $count = 0;
        foreach($dimensions as $dimension){
            $return .= (($count!=0)?' x ':'').$dimension.'m';

            $count += 1;
        }

        return $return;
    }

    public function getBuildingDimensionAttribute()
    {
        $return = [
            'length' => null,
            'width' => null,
        ];

        if(isset($this->attributes['building_dimension'])){
            $explodes = explode('x', $this->attributes['building_dimension']);

            $return = [
                'length' => isset($explodes[0])?$explodes[0]:0,
                'width' => isset($explodes[1])?$explodes[1]:0,
            ];
        }

        return $return;
    }

    public function getBuildingDimensionWithUnitAttribute()
    {
        $dimensions = $this->building_dimension?$this->building_dimension:[];
        $return = '';

        $count = 0;
        foreach($dimensions as $dimension){
            $return .= (($count!=0)?' x ':'').$dimension.'m';

            $count += 1;
        }

        return $return;
    }

    //Mutators
    public function setLandDimensionAttribute($values)
    {
        $empty = true;

        if(is_array($values)){
            foreach($values as $value){
                if(!empty($value)){
                    $empty = false;
                }
            }
        }

        $this->attributes['land_dimension'] = !$empty?implode('x', $values):NULL;
    }

    public function setBuildingDimensionAttribute($values)
    {
        $empty = true;

        if(is_array($values)){
            foreach($values as $value){
                if(!empty($value)){
                    $empty = false;
                }
            }
        }

        $this->attributes['building_dimension'] = !$empty?implode('x', $values):NULL;
    }

    //Scopes
    public function scopeActive($query)
    {
        $query->where($this->getTable().'.status', self::STATUS_ACTIVE);
    }

    public function scopeHasCheckout($query)
    {
        $query->whereNotNull($this->getTable().'.checkout_at');
    }

    //Methods
    public function getPackage($for)
    {
        $qb = $this->packages()->leftJoin('package_categories AS PC', 'PC.id', '=', 'package_category_id')->where('PC.slug', $for);

        $package = $qb->first();

        return $package;
    }

    public function isOwner($user)
    {
        return ($this->user && $user)?($user->id == $this->user->id):FALSE;
    }

    public function getPackageAddons($package)
    {
        foreach($this->packages as $propertyPackage){
            if($propertyPackage->id == $package->id){
                return explode('|', $propertyPackage->pivot->addons);
            }
        }

        return [];
    }

    public function getPhotoThumbnail()
    {
        if($this->photos->count() > 0){
            return $this->photos->first()->filename;
        }

        return 'property-default.jpg';
    }

    public function getMetaDescription()
    {
        $content = [];

        if(!empty($this->land_size+0)){
            $content[] = trans('forms.fields.property.land_size').':'.$this->land_size.' m2';
        }

        if(!empty($this->building_size+0)){
            $content[] = trans('forms.fields.property.building_size').':'.$this->building_size.' m2';
        }

        if($this->isResidential()){
            $content[] = $this->rooms.trans_choice('property.index.bedrooms', $this->rooms);

            $content[] = $this->bathrooms.trans_choice('property.index.bathrooms', $this->bathrooms);
        }

        $return = '';
        $return .= implode(" | ", $content);

        return $return;
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

        if($this->for_sell && $this->for_rent){
            $for = 'both';
        }elseif($this->for_sell){
            $for = 'sell';
        }elseif($this->for_rent){
            $for = 'rent';
        }else{
            $for = 'neither';
        }

        return $for;
    }

    public function getPrice($type)
    {
        if(!in_array($type, ['sell', 'rent'])){
            $type = 'sell';
        }

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
        $propertyAttachment = new PropertyAttachment();

        if($type == 'photo'){
            $uploadPath = $propertyAttachment::$photosUploadPath;
        }elseif($type == 'floorplan'){
            $uploadPath = $propertyAttachment::$floorplanUploadPath;
        }

        $prefix = $this->id.'_'.time();
        $fileName = $prefix.'.'.$photo->getClientOriginalExtension();
        $duplicateCount = 0;
        while(Storage::disk('local')->exists($uploadPath.'/original/'.$fileName)){
            $duplicateCount += 1;
            $fileName = $prefix.($duplicateCount+1).'.'.$photo->getClientOriginalExtension();
        }
        Storage::disk('local')->put($uploadPath.'/original/'.$fileName, File::get($photo));

        $propertyAttachment->fill([
            'title' => filter_var($photo->getClientOriginalName(), FILTER_SANITIZE_STRING),
            'filename' => $fileName,
            'sort_order' => $sort_order,
            'type' => $type
        ]);
        $propertyAttachment->property()->associate($this);
        $propertyAttachment->save();
        $propertyAttachment->resize();

        return $propertyAttachment;
    }

    public function downloadPhoto($type)
    {
        if($type == 'floorplan'){
            $photos = $this->floorplans;
        }else{
            $photos = $this->photos;
        }

        if($photos->count() < 1){
            return false;
        }

        $folder = $photos->first()->getFolder().'download_'.$this->id.'/';

        File::deleteDirectory($folder, true);

        if (!File::exists( $folder.$type )) {
            File::makeDirectory($folder . $type, 0755, true);
        }

        $zipFileName = $this->listing_code.'_'.$type.'.zip';

        $zip = new \ZipArchive;
        $zip->open($folder.$zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach($photos as $photo){
            $file = $photo->createWatermarkedImage('logo_only', 1200, 80, $folder.$type.'/');

            if($file){
                $zip->addFile( $file->dirname.'/'.$file->basename, $file->basename );
            }
        }

        $zip->close();

        return $folder.$zipFileName;
    }

    public function deleteDownloadPhoto($type)
    {
        if($type == 'floorplan'){
            $photos = $this->floorplans;
        }else{
            $photos = $this->photos;
        }

        $folder = $photos->first()->getFolder().'download_'.$this->id.'/';

        File::deleteDirectory($folder, true);
    }

    public function downloadFolderExists($type)
    {
        if($type == 'floorplan'){
            $photos = $this->floorplans;
        }else{
            $photos = $this->photos;
        }

        if($photos->count() < 1){
            return false;
        }

        $folder = $photos->first()->getFolder().'download_'.$this->id.'/';
        return File::exists( $folder.$type );
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
            self::STATUS_REVIEW => trans('property.status.'.self::STATUS_REVIEW),
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
            self::CERTIFICATE_HPL => trans('property.certificate.'.self::CERTIFICATE_HPL),
            self::CERTIFICATE_PPJB => trans('property.certificate.'.self::CERTIFICATE_PPJB),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getOrientationLabel($option=null)
    {
        $array = [
            self::ORIENTATION_NORTH => trans('property.orientation.'.self::ORIENTATION_NORTH),
            self::ORIENTATION_NORTH_EAST => trans('property.orientation.'.self::ORIENTATION_NORTH_EAST),
            self::ORIENTATION_EAST => trans('property.orientation.'.self::ORIENTATION_EAST),
            self::ORIENTATION_SOUTH_EAST=> trans('property.orientation.'.self::ORIENTATION_SOUTH_EAST),
            self::ORIENTATION_SOUTH=> trans('property.orientation.'.self::ORIENTATION_SOUTH),
            self::ORIENTATION_SOUTH_WEST => trans('property.orientation.'.self::ORIENTATION_SOUTH_WEST),
            self::ORIENTATION_WEST => trans('property.orientation.'.self::ORIENTATION_WEST),
            self::ORIENTATION_NORTH_WEST => trans('property.orientation.'.self::ORIENTATION_NORTH_WEST),
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getPhoneLinesLabel($option=null)
    {
        $array = [];
        for($i = 0; $i <= 10; $i += 1){
            $array[$i] = trans_choice('forms.fields.property.phone_line_count', $i);
        }

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getElectricityLabel($option=null)
    {
        $array = [];
        foreach(self::$availableElectricity as $electricity){
            $array[$electricity] = trans('forms.fields.property.watt', ['electricity' => $electricity]);
        }

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getBedroomsLabel($option=null)
    {
        $array = [];
        for($i = 0; $i <= 10; $i += 1){
            $array[$i] = trans_choice('forms.fields.property.room_count', $i);
        }

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getCarsLabel($option=null)
    {
        $array = [];
        for($i = 0; $i <= 10; $i += 1){
            $array[$i] = trans_choice('forms.fields.property.car_count', $i);
        }

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    public static function getMaidBedroomsLabel($option=null)
    {
        $array = [];
        for($i = 0; $i <= 5; $i += 1){
            $array[$i] = trans_choice('forms.fields.property.maid_bedroom_count', $i);
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

    public static function getMaidBathroomsLabel($option=null)
    {
        $array = [];
        for($i = 1; $i <= 5; $i += 1){
            $array[$i] = trans_choice('forms.fields.property.maid_bathroom_count', $i);
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
            '07_00' => '07:00',
            '08_00' => '08:00',
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
            '20_00' => '20:00',
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }

    protected static function boot() {
        parent::boot();

        static::saving(function($model) {
            if(!$model->for_sell){
                $model->sell_price = 0;
            }

            if(!$model->for_rent){
                $model->rent_price = 0;
            }
        });
    }
}
