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
        $folder = config('filesystems.disks.local.root').'/';
        if($this->type == 'photo'){
            $folder .= self::$photosUploadPath.'/';
        }elseif($this->type == 'floorplan'){
            $folder .= self::$floorplanUploadPath.'/';
        }

        $img = Image::make($folder.'original/'.$this->filename)->widen(4096, function ($constraint) {
            $constraint->upsize();
        });
        $img->save($folder.'original/'.$this->filename);

        $img = Image::make($folder.'original/'.$this->filename)->widen(800);
        $img->insert(asset('assets/frontend/images/watermark.png'), 'center');
        $img->save($folder.$this->filename, 60);

        return $img;
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
