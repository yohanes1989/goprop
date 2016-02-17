<?php

namespace GoProp\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['title', 'slug'];

    //Relations
    public function posts()
    {
        return $this->belongsToMany('GoProp\Models\Post');
    }

    public function postsCount()
    {
        return $this->posts()->selectRaw('COUNT(posts.id) AS aggregate')->groupBy('pivot_category_id');
    }

    //Accessors
    public function getPostsCountAttribute()
    {
        if (!$this->relationLoaded('postsCount')) $this->load('postsCount');

        $related = $this->getRelation('postsCount')->first();

        return ($related) ? $related->aggregate : 0;
    }
}
