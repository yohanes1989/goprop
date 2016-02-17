<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MainBannerTranslation extends Model
{
    public static $photosUploadPath = 'images/main_banners';

    public $timestamps = FALSE;

    protected $guarded = ['url', 'sort_order', 'image'];

    public function saveImage($photo)
    {
        $uploadPath = self::$photosUploadPath;

        $this->removeImage();

        $prefix = 'main_banner_'.time();
        $fileName = $prefix.'.'.$photo->getClientOriginalExtension();
        $duplicateCount = 0;
        while(Storage::disk('public')->exists($uploadPath.'/'.$fileName)){
            $duplicateCount += 1;
            $fileName = $prefix.($duplicateCount+1).'.'.$photo->getClientOriginalExtension();
        }
        Storage::disk('public')->put($uploadPath.'/'.$fileName, File::get($photo));

        return $fileName;
    }

    public function removeImage()
    {
        if(!empty($this->image)){
            $uploadPath = self::$photosUploadPath;

            if(Storage::disk('public')->exists($uploadPath.'/'.$this->image)){
                Storage::disk('public')->delete($uploadPath.'/'.$this->image);
            }

            $this->image = NULL;
        }
    }
}
