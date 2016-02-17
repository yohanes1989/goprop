<?php

namespace GoProp\Models;

use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostTranslation extends Model implements SluggableInterface
{
    use SluggableTrait;

    public static $photosUploadPath = 'images/posts';

    public $timestamps = FALSE;

    protected $guarded = ['image', 'categories', 'remove_image', 'status'];
    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
        'on_update' => TRUE
    ];

    //Relations
    public function post()
    {
        return $this->belongsTo('GoProp\Models\Post');
    }

    public function saveImage($photo)
    {
        $uploadPath = self::$photosUploadPath;

        $this->removeImage();

        $prefix = 'post_'.time();
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

    public function duplicateImage()
    {
        $fileName = NULL;

        if($this->image){
            $uploadPath = self::$photosUploadPath;

            $prefix = '';
            $fileName = $prefix.$this->image;

            $duplicateCount = 0;
            while(Storage::disk('public')->exists($uploadPath.'/'.$fileName)){
                $duplicateCount += 1;
                $fileName = ($duplicateCount+1).$fileName;
            }
            Storage::disk('public')->copy($uploadPath.'/'.$this->image, $uploadPath.'/'.$fileName);
        }

        return $fileName;
    }
}
