<?php

namespace GoProp\Models;

use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model implements SluggableInterface
{
    use SluggableTrait;

    public $timestamps = FALSE;

    protected $guarded = [];
    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
        'on_update' => TRUE
    ];

    //Relations
    public function category()
    {
        return $this->belongsTo('GoProp\Models\Category');
    }
}
