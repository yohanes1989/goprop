<?php

namespace GoProp\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Translatable;

    const STATUS_PUBLISHED = 'published';
    const STATUS_UNPUBLISHED = 'unpublished';

    protected $guarded = [];

    public $translatedAttributes = ['title', 'slug', 'teaser', 'content', 'image', 'meta_title', 'meta_description'];

    //Relations
    public function categories()
    {
        return $this->belongsToMany('GoProp\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('GoProp\Models\User');
    }

    //Scopes
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
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

    public static function getStatusLabel($option=null)
    {
        $array = [
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_UNPUBLISHED => 'Unpublished',
        ];

        if(empty($option)){
            return $array;
        }

        return (isset($array[$option]))?$array[$option]:$array;
    }
}
