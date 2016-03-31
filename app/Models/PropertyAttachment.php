<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PropertyAttachment extends Model
{
    public static $photosUploadPath = 'photos';
    public static $floorplanUploadPath = 'floorplans';

    protected $guarded = [];

    //Relations
    public function property()
    {
        return $this->belongsTo('GoProp\Models\Property');
    }

    //Methods
    public function resize()
    {
        $folder = $this->getFolder();

        $img = Image::make($folder.'original/'.$this->filename)->widen(4096, function ($constraint) {
            $constraint->upsize();
        });
        $img->save($folder.'original/'.$this->filename);

        $this->createWatermarkedImage('default');

        return $img;
    }

    public function rotate($dir='right')
    {
        $folder = $this->getFolder();

        $img = Image::make($folder.'original/'.$this->filename);

        if($dir == 'right'){
            $img->rotate(-90);
        }else{
            $img->rotate(90);
        }

        $img->save($folder.'original/'.$this->filename);

        $this->createWatermarkedImage('default');

        return $img;
    }

    public function getFolder()
    {
        $folder = config('filesystems.disks.local.root').'/';
        if($this->type == 'photo'){
            $folder .= self::$photosUploadPath.'/';
        }elseif($this->type == 'floorplan'){
            $folder .= self::$floorplanUploadPath.'/';
        }

        return $folder;
    }

    public function createWatermarkedImage($watermark, $width = 1200, $quality=60, $folder=null)
    {
        if(empty($folder)){
            $folder = $this->getFolder();
        }

        $img = Image::make($this->getFolder().'original/'.$this->filename)->widen($width);

        if($watermark == 'logo_only'){
            $img->insert(asset('assets/frontend/images/watermark_logo_only.png'), 'center');
        }else{
            $img->insert(asset('assets/frontend/images/watermark.png'), 'center');
        }

        return $img->save($folder.$this->filename, $quality);
    }

    //Statics
    protected static function boot() {
        parent::boot();

        static::deleting(function($model) {
            if($model->type == 'photo'){
                $folder = $model::$photosUploadPath;
            }elseif($model->type == 'floorplan'){
                $folder = $model::$floorplanUploadPath;
            }

            if(Storage::disk('local')->exists($folder.'/original/'.$model->filename)){
                Storage::disk('local')->delete($folder.'/original/'.$model->filename);
            }

            if(Storage::disk('local')->exists($folder.'/'.$model->filename)){
                Storage::disk('local')->delete($folder.'/'.$model->filename);
            }
        });
    }
}
