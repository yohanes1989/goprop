<?php

namespace GoProp\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class MainBanner extends Model
{
    use Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['title', 'image'];

    //Scopes
    public function scopeInURL($query, $url)
    {
        if($url){
            $explodes = explode('/', $url);

            foreach($explodes as $idx=>$exploded){
                if($idx == 0){
                    $query->where('url', 'LIKE', $exploded.(count($explodes) > 1?'/%':''));
                }else{
                    $query->where(function($query) use ($explodes, $idx, $exploded){
                        $query->where('url', 'LIKE', $explodes[$idx-1].'/'.$exploded)
                            ->orWhere('url', 'LIKE', $explodes[$idx-1].'/*');
                    });
                }
            }
        }else{
            $query->where('url', 'LIKE', '/');
        }
    }

    //Statics
    protected static function boot() {
        parent::boot();

        static::deleting(function($model) {
            foreach($model->translations as $translation){
                $translation->removeImage();
            }
        });
    }
}
