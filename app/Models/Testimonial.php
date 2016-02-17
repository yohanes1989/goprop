<?php

namespace GoProp\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Testimonial extends Model
{
    use Translatable;

    public static $photosUploadPath = 'testimonials';

    protected $guarded = [];

    public $translatedAttributes = ['title', 'content'];

    public function saveImage($photo)
    {
        $uploadPath = self::$photosUploadPath;

        $this->removeImage();

        $prefix = 'testimonial_'.time();
        $fileName = $prefix.'.'.$photo->getClientOriginalExtension();
        $duplicateCount = 0;
        while(Storage::disk('local')->exists($uploadPath.'/'.$fileName)){
            $duplicateCount += 1;
            $fileName = $prefix.($duplicateCount+1).'.'.$photo->getClientOriginalExtension();
        }
        Storage::disk('local')->put($uploadPath.'/'.$fileName, File::get($photo));

        return $fileName;
    }

    public function removeImage()
    {
        if(!empty($this->image)){
            $uploadPath = self::$photosUploadPath;

            if(Storage::disk('local')->exists($uploadPath.'/'.$this->image)){
                Storage::disk('local')->delete($uploadPath.'/'.$this->image);
            }

            $this->image = NULL;
        }
    }
}
