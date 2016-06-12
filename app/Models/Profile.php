<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Profile extends Model
{
    const TITLE_MR = 'mr';
    const TITLE_MRS = 'mrs';
    const TITLE_MS = 'ms';

    public $timestamps = FALSE;

    protected $guarded = ['extendedProfile', 'profile_picture'];
    protected $uploadPath = 'profile_pictures';

    //Relations
    public function extendedProfile()
    {
        return $this->hasOne('GoProp\Models\ExtendedProfile');
    }

    public function user()
    {
        return $this->belongsTo('GoProp\Models\User');
    }

    //Accessors
    public function getSingleNameAttribute()
    {
        return implode(' ', [$this->first_name, $this->last_name]);
    }

    //Methods
    public function saveProfilePicture($profilePicture)
    {
        $fileName = $this->user->id.'_'.time().'.'.$profilePicture->getClientOriginalExtension();

        Storage::disk('local')->put($this->uploadPath.'/'.$fileName, File::get($profilePicture));
        $this->removeProfilePicture();

        return $fileName;
    }

    public function saveRemoteProfilePicture($profilePicture)
    {
        $image = Image::make($profilePicture);

        $fileName = $this->user->id.'_'.time().'.jpg';
        $filePath = storage_path('tmp').'/'.$fileName;
        $image->save($filePath);

        Storage::disk('local')->put($this->uploadPath.'/'.$fileName, File::get($filePath));
        $this->removeProfilePicture();

        File::delete($filePath);

        return $fileName;
    }

    public function removeProfilePicture()
    {
        if(!empty($this->profile_picture)){
            if(Storage::disk('local')->exists($this->uploadPath.'/'.$this->profile_picture)){
                Storage::disk('local')->delete($this->uploadPath.'/'.$this->profile_picture);
            }

            $this->profile_picture = NULL;
        }
    }

    //Statics
    public static function getTitleLabel($option=null)
    {
        $array = [
            self::TITLE_MR => 'Mr.',
            self::TITLE_MRS => 'Mrs.',
            self::TITLE_MS => 'Ms.'
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }
}
