<?php

namespace GoProp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    //Statics
    protected static function boot() {
        parent::boot();

        static::deleting(function($model) {
            if($model->type == 'photo'){
                $folder = $model::$photosUploadPath;
            }elseif($model->type == 'floorplan'){
                $folder = $model::$floorplanUploadPath;
            }

            if(Storage::disk('local')->exists($folder.'/'.$model->filename)){
                Storage::disk('local')->delete($folder.'/'.$model->filename);
            }
        });
    }
}
